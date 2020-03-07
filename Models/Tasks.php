<?php
    namespace Model;
    use \Config\DB;
    use \Core\AbstractModel;
    use \Core\Helpers;

    class Tasks extends AbstractModel
    {
        public function findAll()
        {
            $sql = "SELECT * FROM task";
            $db = new DB();
            $req = $db->getDb()->prepare($sql);
            $req->execute();
            return $req->fetchAll();
        }

        public function findBy($criteria)
        {
            $db = new DB();

            // get count 
            $sql = "SELECT COUNT(*) FROM task";
            $req = $db->getDb()->prepare($sql);
            $req->execute();
            $count = $req->fetch();

            $order = Helpers::white_list($criteria['order'], ["username","email", "is_closed", "edit_at"], "Invalid ORDER BY direction");
            $direction = Helpers::white_list($criteria['sort'], ["ASC","DESC"], "Invalid ORDER BY direction");
            $sql = "SELECT * FROM task ORDER BY $order $direction LIMIT :recNum OFFSET :pageNum";
            
            $req = $db->getDb()->prepare($sql);
            $req->execute([
                'recNum' => $criteria['recNum'],
                'pageNum' => ($criteria['page']-1)*$criteria['recNum'],
            ]);

            return [
                'tasks' => $req->fetchAll(), 
                'pages' => ceil($count[0] / $criteria['recNum'])
            ];
        }

        public function findById($id)
        {
            $sql = "SELECT * FROM task WHERE id=:id";
            $db = new DB();
            $req = $db->getDb()->prepare($sql);
            $req->execute([
                'id' => $id,
            ]);
            return $req->fetch();
        }

        public function add($persist)
        {
            $sql = "INSERT INTO task (username, text, email, is_closed, created_at, edit_at) VALUES (:username, :text, :email, :is_closed, :created_at, :edit_at)";
            $db = new DB();
            $req = $db->getDb()->prepare($sql);
            return $req->execute([
                'username' => $persist['username'],
                'text' => $persist['text'],
                'email' => $persist['email'],
                'is_closed' => 'false',
                'created_at' => date('d.m.Y H:i:s'),
                'edit_at' => date('d.m.Y H:i:s')
    
            ]);
        }

        public function edit($id, $persist)
        {
            $sql = "UPDATE task SET username = :username, text = :text, email = :email, is_closed = :is_closed, edit_at = :edit_at WHERE id = :id";
            $db = new DB();
            $req = $db->getDb()->prepare($sql);

            return $req->execute([
                'id' => $id,
                'username' => $persist['username'],
                'text' => $persist['text'],
                'email' => $persist['email'],
                'is_closed' => $persist['is_closed'],
                'edit_at' => date('d.m.Y H:i:s')
            ]);
        }

        public function delete($id)
        {
            $sql = "DELETE FROM task WHERE id=:id";
            $db = new DB();
            $req = $db->getDb()->prepare($sql);
            return $req->execute([
                'id' => $id,
            ]);
        }
    }
?>