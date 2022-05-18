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
                <div class="card" id="pagamentoCartao">
                    <div class="card-header text-center font-weight-bold">
                        Pagamento Boleto Teste - Mercado Pago
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <h3 id="msg" class=""></h3>
                            </div>
                        </div>
                        <form id="form-checkout"  method="post" action="{{url('/pagamento')}}">
                            @csrf
                            <form action="/process_payment" method="post" id="paymentForm">

                                <div class="row form-group col-md-12">
                                    <?php /*
                                    <h3>Forma de Pagamento</h3>
                                    <select class="form-control" id="paymentMethod" name="paymentMethod" class="form-control">
                                        <option>Selecione uma forma de pagamento</option>

                                        <!-- Create an option for each payment method with their name and complete the ID in the attribute 'value'. -->
                                        <option value="bolbradesco">Boleto</option>
                                    </select>
                                    <?php */ ?>
                                    <input type="hidden" name="paymentMethod" value="bolbradesco">
                                </div>
                                <h3>Detalhe do comprador</h3>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="payerFirstName">Nome</label>
                                        <input id="payerFirstName" name="payerFirstName" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="payerLastName">Sobrenome</label>
                                        <input id="payerLastName" name="payerLastName" type="text"  class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label for="payerEmail">E-mail</label>
                                        <input id="payerEmail" name="payerEmail" type="text"  class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="docType">Tipo de documento</label>
                                        <select id="docType" name="docType" data-checkout="docType" type="text" class="form-control"></select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="docNumber">Número do documento</label>
                                        <input id="docNumber" name="docNumber" data-checkout="docNumber" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <a  class="btn btn-warning" href="{{ route("index") }}" >Voltar</a>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="transactionAmount" id="transactionAmount" value="84.67">
                                        <input type="hidden" name="productDescription" id="productDescription" value="Produto Fabio Teste">
                                        <button type="submit" class="btn btn-success">Gerar Boleto</button>
                                    </div>

                                </div>
                            </form>

                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mpp = new MercadoPago('<?=env("PUBLIC_KEY_MERCADO_PAGO") ?>', {
        locale: 'en-US'
    })

    // Step #getIdentificationTypes

    // Helper function to append option elements to a select input
    function createSelectOptions(elem, options, labelsAndKeys = { label : "name", value : "id"}){
        const {label, value} = labelsAndKeys;

        elem.options.length = 0;

        const tempOptions = document.createDocumentFragment();

        options.forEach( option => {
            const optValue = option[value];
            const optLabel = option[label];

            const opt = document.createElement('option');
            opt.value = optValue;
            opt.textContent = optLabel;

            tempOptions.appendChild(opt);
        });

        elem.appendChild(tempOptions);
    }

    // Get Identification Types
    (async function getIdentificationTypes () {
        try {
            const identificationTypes = await mpp.getIdentificationTypes();
            const docTypeElement = document.getElementById('docType');

            createSelectOptions(docTypeElement, identificationTypes)
        }catch(e) {
            return console.error('Error getting identificationTypes: ', e);
        }
    })()

</script>
</body>
</html>
