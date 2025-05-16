<?php

namespace App\Services;
use App\Repositories\JournalSelfRepository;
class JournalSelfService
{
    protected $journalSelfRepo;


    public function __construct(JournalSelfRepository $journalSelfRepo)
    {
        $this->journalSelfRepo = $journalSelfRepo;
    }
    public function getAll()
    {
        return $this->journalSelfRepo->getAll();
    }

    public function getById($id)
    {
        return $this->journalSelfRepo->findById($id);
    }
    public function create(array $data)
    {
        // Nếu cần logic xử lý gì thì thêm ở đây
        return $this->journalSelfRepo->create($data);
    }
    public function update($id, array $data)
    {
        return $this->journalSelfRepo->update($id, $data);
    }
    public function delete($id)
    {
        return $this->journalSelfRepo->delete($id);
    }
}