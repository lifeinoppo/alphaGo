<?php

// start to use the bae database mysql 
	
	Class simpledbProxy{

		private $link_id;
		// construct function 
		public function __construct($username,$password){

			// replace this later 
			$dbname = 'oLsAGsURBcfcbcNEAPTv';

			// get params from environment , debug this first 
			$host = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
			$port = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');
			// can not get ak/sk directly from db env,so manually provided 
			$user = $username;
			$pwd = $password;
			$this->connect($dbname,$host,$user,$port,$pwd);


		}

		// connect to mysql server
		public function connect($dbname,$host,$user,$port,$pwd){
			$this->link_id = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
			if(!$this->link_id){
				die("Connect Server Failed: " . mysql_error());  // mysql connect failure 
			}

			// if success with mysql connection 
			if(!mysql_select_db($dbname,$this->link_id)){
				die("Select Database Failed: " . mysql_error($this->link_id));
			}

		}

		    //查询 
        public function query($sql) {
                $query = mysql_query($sql,$this->link_id);
                if(!$query) $this->halt('Query Error: ' . $sql);
                return $query;
        }
        
        //获取一条记录（MYSQL_ASSOC，MYSQL_NUM，MYSQL_BOTH）				
        public function get_one($sql,$result_type = MYSQL_ASSOC) {
                $query = $this->query($sql);
                $rt =& mysql_fetch_array($query,$result_type);
                return $rt;
        }

        //获取全部记录
        public function get_all($sql,$result_type = MYSQL_ASSOC) {
                $query = $this->query($sql);
                $i = 0;
                $rt = array();
                while($row =& mysql_fetch_array($query,$result_type)) {
                        $rt[$i]=$row;
                        $i++;
                }
                return $rt;
        }
        
        //插入
        public function insert($table,$dataArray) {
                $field = "";
                $value = "";
                if( !is_array($dataArray) || count($dataArray)<=0) {
                        $this->halt('没有要插入的数据');
                        return false;
                }
                while(list($key,$val)=each($dataArray)) {
                        $field .="$key,";
                        $value .="'$val',";
                }
                $field = substr( $field,0,-1);
                $value = substr( $value,0,-1);
                $sql = "insert into $table($field) values($value)";
                if(!$this->query($sql)) return false;
                return true;
        }

        //更新
        public function update( $table,$dataArray,$condition="") {
                if( !is_array($dataArray) || count($dataArray)<=0) {
                        $this->halt('没有要更新的数据');
                        return false;
                }
                $value = "";
                while( list($key,$val) = each($dataArray))
                $value .= "$key = '$val',";
                $value .= substr( $value,0,-1);
                $sql = "update $table set $value where 1=1 and $condition";
                if(!$this->query($sql)) return false;
                return true;
        }

        //删除
        public function delete( $table,$condition="") {
                if( empty($condition) ) {
                        $this->halt('没有设置删除的条件');
                        return false;
                }
                $sql = "delete from $table where 1=1 and $condition";
                if(!$this->query($sql)) return false;
                return true;
        }

        //返回结果集
        public function fetch_array($query, $result_type = MYSQL_ASSOC){
                return mysql_fetch_array($query, $result_type);
        }

        //获取记录条数
        public function num_rows($results) {
                if(!is_bool($results)) {
                        $num = mysql_num_rows($results);
                        return $num;
                } else {
                        return 0;
                }
        }

        //释放结果集
        public function free_result() {
                $void = func_get_args();
                foreach($void as $query) {
                        if(is_resource($query) && get_resource_type($query) === 'mysql result') {
                                return mysql_free_result($query);
                        }
                }
        }

        //获取最后插入的id
        public function insert_id() {
                $id = mysql_insert_id($this->link_id);
                return $id;
        }

        //关闭数据库连接
        protected function close() {
                return @mysql_close($this->link_id);
        }

        //错误提示
        private function halt($msg='') {
                $msg .= "\r\n".mysql_error();
                die($msg);
        }

        //析构函数
        public function __destruct() {
                $this->free_result();
        }

        //获取毫秒数
        public function microtime_float() {
                list($usec, $sec) = explode(" ", microtime());
                return ((float)$usec + (float)$sec);
        }



	}
	


?>