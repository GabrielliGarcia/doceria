<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Registrar uma nova conta" />
    <meta name="author" content="Seu Nome" />
    <title>Registrar - Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f0f2f5; /* Fundo mais suave */
        }

        .card {
            margin-top: 100px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-floating label {
            color: #6c757d; /* Cor suave para os placeholders */
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header text-center">
                        <h3 class="font-weight-light my-3">Criar Conta</h3>
                    </div>
                    <div class="card-body">
                        <!-- Exibição de erros -->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Formulário de registro -->
                        <form method="post" action="/registrarAdmin">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputName" type="text" name="name" placeholder="Nome completo" required>
                                <label for="inputName"><i class="fas fa-user"></i> Nome</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" required>
                                <label for="inputEmail"><i class="fas fa-envelope"></i> Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Senha" required>
                                <label for="inputPassword"><i class="fas fa-lock"></i> Senha</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputPasswordConfirmation" name="password_confirmation" type="password" placeholder="Confirmar Senha" required>
                                <label for="inputPasswordConfirmation"><i class="fas fa-lock"></i> Confirmar Senha</label>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="submit">Registrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small">
                            Já tem uma conta? <a href="{{ route('loginAdmin') }}">Entrar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
