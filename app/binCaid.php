<?php
    require_once "./core/DB.php";
    class binCaid extends DB{

        public function getRecords() {
            $query = "SELECT * FROM bincaid ORDER BY bincaid_id  desc  limit 5 ";
            $result = $this->db->query($query);
            $records = [];
    
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $records[] = $row;
                }
            }
    
            return $records;
        }

        public function getBinCaid() {
            $query = "SELECT bin,caid FROM bincaid";
            $result = $this->db->query($query);
            $records = [];
    
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $records[] = $row;
                }
            }
    
            return $records;
        }

        public function getRecordID($bincaid_ID){
            $query = "SELECT * FROM bincaid where bincaid_id = ".$bincaid_ID;
            $result = $this->db->query($query);
            $records = [];
    
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $records[] = $row;
                }
            }
    
            return $records;
        }

        //Add a new bincaid
        public function add($bin, $caid, $status, $comment, $ruleset) {
            $BinCaids = $this->getBinCaid();
            foreach ($BinCaids as $value) {
                if($value["bin"] == $bin){
                    if($value["caid"] == $caid){
                        return false;
                    }
                }
            }
            try{
                $query = "INSERT INTO bincaid (bin, caid, status, comment, ruleset) 
                      VALUES ('$bin', '$caid', '$status', '$comment', '$ruleset')";
                $result = $this->db->query($query);
                return $result;
                
            }catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                return false;
            }
        }

        //Takes in a merchantId, add merchant in a bincaid
        public function merchantAdd($bincaid_id, $merchant_id) {
            try{
                $query = "UPDATE bincaid SET merchant_id = $merchant_id WHERE bincaid_id = ".$bincaid_id;
                $result = $this->db->query($query);
                return $result;
                
            }catch (Exception $e) {
                // echo 'Caught exception: ',  $e->getMessage(), "\n";
                return false;
            }
        }
    
        //Set enable for a bincaid when status = 1
        public function enable($bincaid_id) {
            try{
                $query = "UPDATE bincaid SET status = 1 WHERE bincaid_id = '$bincaid_id'";
                $result = $this->db->query($query);
                return $result;
                
            }catch (Exception $e) {
                // echo 'Caught exception: ',  $e->getMessage(), "\n";
                return false;
            }
        }
    
        //Return true if a bincaid status = 1, else returns false
        public function isEnable($bincaid_id) {
            $query = "SELECT status FROM bincaid WHERE bincaid_id = '$bincaid_id'";
            $result = $this->db->query($query);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["status"] == 1;
            }
            return false;
        }

        //Close connect db
        public function __destruct() {
            $this->db->close();
        }
    }
?>