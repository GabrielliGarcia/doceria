<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suspire 🧁</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/estilo.css') }}">

</head>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<body>
    <section class="barra_navegacao">  
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="navbar-brand" href="/vendas"> Suspire 🧁 </a>
        </li>

        <li class="nav-item">
            <a class="nav-link active" href="/vendas">Inicio</a>
        </li>       
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Categorias
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach($categorias as $dado)
              <a class="dropdown-item" href="/vendas/categoria/{{$dado['id']}}">{{$dado["nome"]}}</a>
            @endforeach                
            </div>
          </li>
      </ul>      


      @if(Auth::check())
        <!-- Exibe o botão "Minha conta" se o usuário estiver logado -->
        <span class="navbar-text">
            <a class="btn btn-rosa-conta" href="/minha-conta">Minha conta</a>
        </span>
      @else
        <!-- Exibe os botões "Entre" e "Cadastre-se" se o usuário NÃO estiver logado -->
        <span class="navbar-text">
            <a class="btn btn-rosa" href="{{ route('login') }}">Entre</a>
            <a class="btn btn-rosa" href="{{ route('register') }}">Cadastre-se</a>
        </span>
      @endif

        <span class="navbar-text">
            <a class="btn btn-outline-light" href="/vendas/exibir-carrinho">🛒 Carrinho</a>
        </span>
    </div>
  </div>
</nav>

</section>
    <section class="conteudo">
      @csrf

    <!-- Nova seção para a imagem e o texto -->
          
    <div class="container borda-container">
        <div class="row align-items-start">
            <div class="col">
                <h2 class="mt-4 texto-bem-vindo">Bem-vindo à Suspire, a melhor loja de doces!</h2>
                <br>
                <p class="mt-2 texto-bem-vindo fs-5">Pensada e criada para alimentar além do corpo, a alma! Aqui você encontra os mais deliciosos doces feitos com muito carinho!</p>
            </div>
            <div class="col-auto">
                <img src="{{ asset('img/produtos/doce.png') }}" class="img-fluid mb-3" alt="Doce">
            </div>
        </div>
    </div>

    </br>
    
    <hr class="sidebar-divider d-none d-md-block">

    <div class="card_title">
      <div class="card">
        <div class="card-body text-center">          
          <h2 id="produtos">Doces</h2>          
        </div>
      </div>
    </div>
    <div class="card_itens">
      <div class="row">
    @foreach($vendas as $dados)       
        <div class="col-sm-3">
          <div class="card text-center text-bg-dark" style="width: 20rem;">
            <img src="{{ asset('img/produtos/' . $dados["imagem"]) }}" class="card-img-top" alt="..." id="imagem">
            <div class="card-body">
              <h5 class="card-title">{{$dados["nome"]}}</h5>              
              <p class="card-text" id='preco'>Preço: {{$dados["preco"]}}</p>
              <a class="btn btn-outline-light" href="/vendas/comprar/{{$dados['id']}}">Selecionar</a>
            </div>
          </div>
        </div>              
    @endforeach
      </div>            
    </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>