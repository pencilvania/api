<?php


namespace App\Repositories\Affiliations;


interface AffiliationsInterface
{
        public function getAll();
        public function remove($id);
        public function create(array $data);

}
