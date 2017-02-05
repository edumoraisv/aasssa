<?php
namespace Concursos\Modules;

interface CandidatosInterface {
    public function cadastrarOuAtualizar(array $dados);
    public function recuperarSenha(string $email);
    public function consultar(string $criterios): array;
}
