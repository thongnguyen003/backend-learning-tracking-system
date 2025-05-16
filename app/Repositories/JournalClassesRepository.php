<?php
    namespace App\Repositories;
    use App\Models\JournalClasses;
    class JournalClassesRepository{
        public function getAll(){
            return JournalClasses::all();
        }
        public function findById($id){
            return JournalClasses::findOrFail($id);
        }
        public function create(array $data){
            return JournalClasses::created($data);
        }
        public function update($id, array $data){
            $item = $this->findById($id);
            $item->update($data);
            return $item;
        }
        public function delete($id){
            return JournalClasses::destroy($id);
        }
    }
?>

