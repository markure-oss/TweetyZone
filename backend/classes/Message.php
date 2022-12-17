<?php
class Message{
    private $pdo;

    public function __construct(){
        $this->pdo=Database::instance();
    }

    public function recentMessages($userid){
        $stmt=$this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN `users` ON `messageFrom`=`user_id` AND `messageID` IN (SELECT max(`messageID`) FROM `messages` WHERE `messageFrom`=`user_id`) WHERE `messageTo`=:user_id AND `messageFrom`=`user_id` GROUP BY `user_id` ORDER BY `messageID` DESC");
        $stmt->bindParam(":user_id",$userid,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_OBJ);
    }

    public function messageData($otherid,$userid){
        $stmt=$this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN `users` ON `messageFrom`=`user_id` WHERE (`messageFrom`=:otherid AND `messageTo`=:user_id) OR (`messageFrom`=:user_id AND `messageTo`=:otherid) ORDER BY `messageOn` ASC");
        $stmt->bindParam(":user_id",$userid,PDO::PARAM_INT);
        $stmt->bindParam(":otherid",$otherid,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_OBJ);
    }
}