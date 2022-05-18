<!DOCTYPE html>
<html>
<head>
    <title>Pagamento Mercado Pago - Teste</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//getbootstrap.com/docs/4.6/dist/css/bootstrap.min.css">
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago('TEST-33d6d38f-395c-4f24-a9e7-2267ddf4d259');
        // Step #3
        const cardForm = mp.cardForm({
            amount: "100.5",
            autoMount: true,
            form: {
                id: "form-checkout",
                cardholderName: {
                    id: "form-checkout__cardholderName",
                    placeholder: "Titular do cartão",
                },
                cardholderEmail: {
                    id: "form-checkout__cardholderEmail",
                    placeholder: "E-mail",
                },
                cardNumber: {
                    id: "form-checkout__cardNumber",
                    placeholder: "Número do cartão",
                },
                expirationDate: {
                    id: "form-checkout__expirationDate",
                    placeholder: "Data de vencimento (MM/YYYY)",
                },
                securityCode: {
                    id: "form-checkout__securityCode",
                    placeholder: "Código de segurança",
                },
                installments: {
                    id: "form-checkout__installments",
                    placeholder: "Parcelas",
                },
                identificationType: {
                    id: "form-checkout__identificationType",
                    placeholder: "Tipo de documento",
                },
                identificationNumber: {
                    id: "form-checkout__identificationNumber",
                    placeholder: "Número do documento",
                },
                issuer: {
                    id: "form-checkout__issuer",
                    placeholder: "Banco emissor",
                },
            },
            callbacks: {
                onFormMounted: error => {
                    if (error) return console.warn("Form Mounted handling error: ", error);
                    console.log("Form mounted");
                },
                onSubmit: event => {
                    event.preventDefault();

                    const {
                        paymentMethodId: payment_method_id,
                        issuerId: issuer_id,
                        cardholderEmail: email,
                        amount,
                        token,
                        installments,
                        identificationNumber,
                        identificationType,
                    } = cardForm.getCardFormData();

                    fetch("/process_payment", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            token,
                            issuer_id,
                            payment_method_id,
                            transaction_amount: Number(amount),
                            installments: Number(installments),
                            description: "Descrição do produto",
                            payer: {
                                email,
                                identification: {
                                    type: identificationType,
                                    number: identificationNumber,
                                },
                            },
                        }),
                    });
                },
                onFetching: (resource) => {
                    console.log("Fetching resource: ", resource);

                    // Animate progress bar
                    const progressBar = document.querySelector(".progress-bar");
                    progressBar.removeAttribute("value");

                    return () => {
                        progressBar.setAttribute("value", "0");
                    };
                }
            },
        });
    </script>
</head>
<body>
<div class="container mt-4">
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            Pagamento Teste - Mercado Pago
        </div>
        <div class="card-body">
            <form id="form-checkout"  method="post" action="{{url('/pagamento')}}">
                @csrf
                <div class="form-group">
                    <div class="row col-md-2">
                        <label for="exampleInputEmail1">Número do Cartão</label>
                        <input type="text" name="cardNumber" id="form-checkout__cardNumber" class="form-control" required=""/>
                    </div>
                    <div class="row col-md-2">
                        <label for="exampleInputEmail1">Data Expie</label>
                        <input type="text" name="expirationDate" id="form-checkout__expirationDate" class="form-control" required=""/>
                    </div>


                </div>
                <div class="form-group">
                    <div class="row col-md-2">
                        <label for="exampleInputEmail1">Pagamento (R$)</label>
                        <input type="text" id="title" name="Valor do Pagamento" class="form-control" required="">
                    </div>
                    <div class="row col-md-2">
                        <label for="exampleInputEmail1">Pagamento (R$)</label>
                        <input type="text" id="title" name="Valor do Pagamento" class="form-control" required="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="row col-md-2">
                        <label for="exampleInputEmail1">Pagamento (R$)</label>
                        <input type="text" id="title" name="Valor do Pagamento" class="form-control" required="">
                    </div>
                    <div class="row col-md-1">
                        <label for="exampleInputEmail1">Pagamento (R$)</label>
                        <input type="text" id="title" name="Valor do Pagamento" class="form-control" required="">
                    </div>
                    <div class="row col-md-1">
                        <label for="exampleInputEmail1">Pagamento (R$)</label>
                        <input type="text" id="title" name="Valor do Pagamento" class="form-control" required="">
                    </div>
                    <div class="row col-md-2">
                        <label for="exampleInputEmail1">Pagamento (R$)</label>
                        <input type="text" id="title" name="Valor do Pagamento" class="form-control" required="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="row col-md-6">

                        <input type="text" name="cardholderName" id="form-checkout__cardholderName"/>
                        <input type="email" name="cardholderEmail" id="form-checkout__cardholderEmail"/>
                        <input type="text" name="securityCode" id="form-checkout__securityCode" />
                        <select name="issuer" id="form-checkout__issuer"></select>
                        <select name="identificationType" id="form-checkout__identificationType"></select>
                        <input type="text" name="identificationNumber" id="form-checkout__identificationNumber"/>
                        <select name="installments" id="form-checkout__installments"></select>
                        <button type="submit" id="form-checkout__submit">Pagar</button>
                        <progress value="0" class="progress-bar">Carregando...</progress>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Realizar Pagamento</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
