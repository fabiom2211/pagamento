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
                        Pagamento Teste - Mercado Pago
                    </div>
                    <div class="card-body">
                        <div class="row form-group" id="actions" >
                            <div class="col-md-6">
                                <a id="gerarBoleto" href="{{ route("boleto") }}" class="btn btn-info">Pagar com Boleto</a>
                            </div>
                            <div class="col-md-6">
                                <a id="gerarCartao" href="{{ route("cartao") }}" class="btn btn-info">Pagar com Cartão</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>

// $("#boleto").hide();
// $("#cartao").hide();
//     $(document).ready(function() {
//
//         $("#gerarCartao").click(function(){
//             $("#boleto").hide();
//             $("#actions").hide();
//             $("#cartao").toggle();
//         });
//         $("#gerarBoleto").click(function(){
//             $("#cartao").hide();
//             $("#actions").hide();
//             $("#boleto").toggle();
//         });
//     });
</script>
</body>
</html>
