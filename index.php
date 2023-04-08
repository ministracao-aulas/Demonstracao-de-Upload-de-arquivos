<?php
require_once __DIR__ . '/session.php';
$success = flashGet('success');
$error = flashGet('error');
if ($success) {
    $messages['success'] = $success;
}

if ($error) {
    $messages['error'] = $error;
}

$classColors = [
    'success' => 'success',
    'error' => 'danger',
    'warning' => 'warning',
    'info' => 'info',
];

$listaDeArquivosJson = __DIR__ . "/uploads/arquivos.json";

$listaDeArquivos = file_exists($listaDeArquivosJson)
    ? json_decode(file_get_contents($listaDeArquivosJson))
    : [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 5.2.3</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }
    </style>
</head>

<body>
    <div class="container-box p-4">
        <div class="mb-2">
            <h4 class="text-center">Upload de arquivos</h4>
        </div>

        <?php if ($messages ?? null) : ?>
            <div class="row p-0 m-0">
                <?php foreach ($messages as $type => $message) : ?>
                    <div class="col alert alert-<?= $classColors[$type] ?? 'info' ?> alert-dismissible fade show py-1" role="alert">
                        <strong><?= ucfirst($type) ?></strong> <?= $message ?>
                        <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <form action="processar-formulario.php" method="post" enctype="multipart/form-data">
            <div class="row p-5 mb-3">
                <div class="input-group mb-3">
                    <input type="file" name="arquivo01" class="form-control" id="inputGroupFile01" required>
                    <label class="input-group-text" for="inputGroupFile01">Selecionar aquivo</label>
                </div>

                <div class="input-group my-3">
                    <button class="btn btn-block btn-outline-primary" type="submit">
                        Enviar
                    </button>
                </div>
            </div>
        </form>

        <?php if ($listaDeArquivos ?? []) : ?>
            <div class="row">
                <div class="mb-2">
                    <h4 class="text-center">Arquivos no servidor</h4>
                </div>
                <ul class="list-group">
                    <?php foreach (($listaDeArquivos ?? []) as $arquivo) : ?>
                        <li class="list-group-item">
                            <a href="<?= $arquivo ?>"><?= $arquivo ?></a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js" integrity="sha512-i9cEfJwUwViEPFKdC1enz4ZRGBj8YQo6QByFTF92YXHi7waCqyexvRD75S5NVTsSiTv7rKWqG9Y5eFxmRsOn0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
