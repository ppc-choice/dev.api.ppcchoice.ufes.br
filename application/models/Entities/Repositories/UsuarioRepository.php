<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class UsuarioRepository extends EntityRepository
{
    public function findByNome()
    {
        return $this->_em->createQuery('SELECT u FROM Entities\Usuario u WHERE u.nome like \'%l%\' ')
        ->getResult();
    }
}