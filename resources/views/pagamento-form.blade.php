<!DOCTYPE html>
<html>
<head>
    <title>Pagamento Mercado Pago - Teste</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//getbootstrap.com/docs/4.6/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
        <div class="row form-group">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center font-weight-bold">
                        Pagamento Cartão Teste - Mercado Pago
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <h3 id="msg" class=""></h3>
                            </div>
                        </div>
                        <form id="form-checkout"  method="post" action="{{url('/pagamento')}}">
                            @csrf
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <input type="text" name="cardNumber" id="form-checkout__cardNumber" class="form-control"/>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="cardExpirationMonth" id="form-checkout__cardExpirationMonth" class="form-control"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <input type="text" name="cardExpirationYear" id="form-checkout__cardExpirationYear" class="form-control"/>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="cardholderName" id="form-checkout__cardholderName" class="form-control"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <input type="email" name="cardholderEmail" id="form-checkout__cardholderEmail"class="form-control"/>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="securityCode" id="form-checkout__securityCode" class="form-control"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <select name="identificationType" id="form-checkout__identificationType" class="form-control"></select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="identificationNumber" id="form-checkout__identificationNumber" class="form-control"/>
                                </div>

                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <select name="issuer" id="form-checkout__issuer" class="form-control"></select>
                                </div>
                                <div class="col-md-6">
                                    <select name="installments" id="form-checkout__installments" class="form-control"></select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <a  class="btn btn-warning" href="{{ route("index") }}" >Voltar</a>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" id="form-checkout__submit" class="btn btn-success">Pagar</button>
                                </div>
                                <div class="col-md-6">
                                    <progress value="0" class="progress-bar">loading...</progress>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mp = new MercadoPago('<?=env("PUBLIC_KEY_MERCADO_PAGO") ?>', {
        locale: 'en-US'
    })

    const cardForm = mp.cardForm({
        amount: '84.67',
        autoMount: true,
        processingMode: 'aggregator',
        form: {
            id: 'form-checkout',
            cardholderName: {
                id: 'form-checkout__cardholderName',
                placeholder: 'Cardholder name',
            },
            cardholderEmail: {
                id: 'form-checkout__cardholderEmail',
                placeholder: 'Email',
            },
            cardNumber: {
                id: 'form-checkout__cardNumber',
                placeholder: 'Card number',
            },
            cardExpirationMonth: {
                id: 'form-checkout__cardExpirationMonth',
                placeholder: 'MM'
            },
            cardExpirationYear: {
                id: 'form-checkout__cardExpirationYear',
                placeholder: 'YYYY'
            },
            securityCode: {
                id: 'form-checkout__securityCode',
                placeholder: 'CVV',
            },
            installments: {
                id: 'form-checkout__installments',
                placeholder: 'Total installments'
            },
            identificationType: {
                id: 'form-checkout__identificationType',
                placeholder: 'Document type'
            },
            identificationNumber: {
                id: 'form-checkout__identificationNumber',
                placeholder: 'Document number'
            },
            issuer: {
                id: 'form-checkout__issuer',
                placeholder: 'Issuer'
            }
        },
        callbacks: {
            onFormMounted: error => {
                //if (error) return $("#msg").html("Form mounted").addClass("alert alert-warning")//console.log('Form mounted');
            },
            onFormUnmounted: error => {
                //if (error) return $("#msg").html("Form mounted").addClass("alert alert-warning")//console.log('Form unmounted')
            },
            onIdentificationTypesReceived: (error, identificationTypes) => {
                if (error) return $("#msg").html('Tipos de identificação disponiveis: CPF/CNPJ').addClass("alert alert-warning")//console.log('Identification types available: ', identificationTypes)
            },
            onPaymentMethodsReceived: (error, paymentMethods) => {
                if (error){
                    return $("#msg").html("Método de Pagamento Disponiveis").addClass("alert alert-warning")
                } //console.log('Payment Methods available: ', paymentMethods)
            },
            onIssuersReceived: (error, issuers) => {
                if (error) return $("#msg").html("Form mounted").addClass("alert alert-warning")//console.log('Issuers available: ', issuers)
            },
            onInstallmentsReceived: (error, installments) => {
                if (error){
                    return $("#msg").html("installments handling error").addClass("alert alert-warning")
                } //console.log('Installments available: ', installments)
            },
            onCardTokenReceived: (error, token) => {
                if (error) return $("#msg").html("Token available").addClass("alert alert-warning")//console.log('Token available: ', token)
            },
            // onSubmit: (event) => {
            //     event.preventDefault();
            //     const cardData = cardForm.getCardFormData();
            //     console.log('CardForm data available: ', cardData)
            // },
            onFetching:(resource) => {
                //console.log('Fetching resource: ', resource)

                // Animate progress bar
                const progressBar = document.querySelector('.progress-bar')
                progressBar.removeAttribute('value')

                return () => {
                    progressBar.setAttribute('value', '0')
                }
            },
        }
    })
</script>
</body>
</html>
