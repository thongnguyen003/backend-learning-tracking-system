<?php

    namespace App\Repositories;
    use App\Models\JournalClasses;
    use Illuminate\Support\Facades\Log;
    class JournalClassesRepository{
        public function getAll(){
            return JournalClasses::all();
        }
        public function findById($id){
            return JournalClasses::find($id);
        }
        public function create(array $data){
            return JournalClasses::create($data);
        }   
        public function update($id, array $data){
            $item = $this->findById($id);
            Log::info('Process Information', [
                    'start' => $item,
                ]);
            $item->update($data);
            return $item;
        }
        public function delete($id){
            return JournalClasses::destroy($id);
        }
    }
?>