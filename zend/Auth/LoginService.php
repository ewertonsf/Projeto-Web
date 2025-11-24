<?php

namespace Auth;

use Doctrine\ORM\EntityManager;
use Entity\Usuario;

class LoginService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function autenticar($email, $senha)
    {
        $usuario = $this->em->getRepository(Usuario::class)
            ->findOneBy(['email' => $email]);

        if (!$usuario) {
            return false;
        }

        if (password_verify($senha, $usuario->getSenha())) {
            return $usuario;
        }

        return false;
    }
}
