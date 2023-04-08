<?php

require_once __DIR__ . '/session.php';

function processaArquivo(?array $arquivo)
{
    try {
        if (!$arquivo || $arquivo['error'] ?? null) {
            flashPut('error', 'Falha ao fazer upload do arquivo');
            return false;
        }

        $uploadDir = 'uploads';
        $nomeOriginal = $arquivo['name'] ?? null;
        $caminhoTemporario = $arquivo['tmp_name'] ?? '';
        $novoNome = str_replace([' '], '-', date('YmdHis') . "-{$nomeOriginal}");
        $novoNome = str_replace(['--', '(', ')'], '-', $novoNome);
        $caminhoNovo = "{$uploadDir}/{$novoNome}";

        if (
            !file_exists($caminhoTemporario) ||
            !move_uploaded_file($caminhoTemporario, __DIR__ . "/{$caminhoNovo}")
        ) {
            flashPut('error', "Falha ao fazer upload do arquivo '{$nomeOriginal}'");
            return false;
        }

        $listaDeArquivosJson = __DIR__ . "/{$uploadDir}/arquivos.json";

        $listaDeArquivos = file_exists($listaDeArquivosJson)
            ? json_decode(file_get_contents($listaDeArquivosJson))
            : [];

        $listaDeArquivos[] = $caminhoNovo;

        file_put_contents($listaDeArquivosJson, json_encode($listaDeArquivos, JSON_PRETTY_PRINT));

        return true;
    } catch (\Throwable $th) {
        throw $th;

        return false;
    }
}

$arquivos = $_FILES ?? [];

$arquivo01 = $arquivos['arquivo01'] ?? null;

if (!$arquivo01) {
    flashPut('error', "O arquivo 01 é obrigatório");
    header("Location: ./index.php");
    die;
}

$sucesso = $arquivo01 && processaArquivo($arquivo01);

if (!$sucesso) {
    // flashPut('error', 'O arquivo 01 é obrigatório!');
    header("Location: ./index.php");
    die;
}

flashPut('success', 'Arquivo 01 feito upload com sucesso!');

header("Location: ./index.php");
die;
