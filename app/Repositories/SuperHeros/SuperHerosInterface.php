<?php


namespace App\Repositories\SuperHeros;


interface SuperHerosInterface
{
        public function getAll();
        public function getById($id);
        public function getByName($name);
        public function getRealNameById($id);
        public function getHeroNameById($id);
        public function getPublisherById($id);
        public function getAffiliationsById($id);
        public function create(array $data);
        public function update(array $data, $id);
        public function remove($id);

}
