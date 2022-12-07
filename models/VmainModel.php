<?php
    if($IsAjax){
        require_once "../config/SERVER.php";
    }else{
        require_once "./config/SERVER.php";
    }

    class VmainModel{
        /*------- Function for connect BD --------- */
        protected static function Conn(){
            $conection = new PDO(SGBD,USER,PASS);
            $conection->exec("SET CHARACTER SET utf8");
            return $conection;
        }
        /*------- Function for simple query BD --------- */
        protected static function exec_simple_query($query){
            /*self reference to function to same class  */
            $sql = self::Conn()->prepare($query);
            $sql->execute();
            return $sql;
        }

        /*------- encryption chain --------- */
        public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

        /*------- decryption chain --------- */
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

        /*------- function ramdom code for loans --------- */
        protected static function Fgenerate_ramdom_code($letter,$lenght,$number){
            for($i=1;$i <= $lenght; $i++){
                $ramdom= rand(0,9);
                $letter.=$ramdom;
            }
             return $letter."-".$number;
        }

        /*------- function for clean string --------- */
        protected static function Fclean_string($string){
            $string = trim($string);
            //trim delete blanck space before and after to text
            $string = stripslashes($string);
            //stripslashes delete backslash
            $string = str_replace("<script>","",$string);
            $string = str_replace("</script>","",$string);
            $string = str_replace("<script src","",$string);
            $string = str_replace("<script type =","",$string);
            $string = str_replace("SELECT * FROM","",$string);
            $string = str_replace("DELETE FROM","",$string);
            $string = str_replace("INSERT INTO","",$string);
            $string = str_replace("DROP TABLE","",$string);
            $string = str_replace("DROP DATABASE","",$string);
            $string = str_replace("TRUNCATE TABLE","",$string);
            $string = str_replace("SHOW TABLES","",$string);
            $string = str_replace("SHOW DATABASE","",$string);
            $string = str_replace("<?php","",$string);
            $string = str_replace("?>","",$string);
            $string = str_replace("--","",$string);
            $string = str_replace("<","",$string);
            $string = str_replace(">","",$string);
            $string = str_replace("[","",$string);
            $string = str_replace("]","",$string);
            $string = str_replace("^","",$string);
            $string = str_replace("==","",$string);
            $string = str_replace(";","",$string);
            $string = str_replace("::","",$string);
            $string = stripslashes($string);
            $string = trim($string);
            return $string;
        }

        /*------- function check data --------- */
        protected static function Fcheck_data($filter,$string){
            if(preg_match("/^".$filter."$/",$string)){
                return false;
            }else{
                return true;
            }
        }

        /*------- function check date --------- */
        protected static function Fcheck_date($date){
            $Values = explode('-',$date);
            if(count($Values)==3 && checkdate($Values[1],$Values[2],$Values[0])){
                return false;
            }else{
                return true;
            }
        }

        /*------- function table pagination --------- */
        protected static function F_pagination_tables($page,$Npage,$url,$buttons){
            $table = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

            if($page==1){
                $table.='<li class="page-item disabled"><a class="page-link"><i class="fas fa-angle-double-left"></i></a></li>';
            }else{
                $table.='<li class="page-item"><a class="page-link" href="'.$url.$Npage.'/"><i class="fas fa-angle-double-left"></i></a></li>';
                $table.='<li class="page-item"><a class="page-link" href="'.$url.($page-1).'/">Anterior</a></li>';
            }

            $ci = 0;
            for($i=$page;$i<=$Npage;$i++){
                if($ci>=$buttons){
                    break;
                }

                if($page==$i){
                    $table.='<li class="page-item"><a class="page-link active" href="'.$url.$i.'/">'.$i.'</a></li>';
                }else{
                    $table.='<li class="page-item"><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>';
                }
                $ci++;
            }

            if($page==$Npage){
                $table.='<li class="page-item disabled"><a class="page-link"><i class="fas fa-angle-double-right"></i></a></li>';
            }else{
                $table.='<li class="page-item"><a class="page-link" href="'.$url.($page+1).'/">Siguiente</a></li>';
                $table.='<li class="page-item"><a class="page-link" href="'.$url.$Npage.'/"><i class="fas fa-angle-double-right"></i></a></li>';                
            }

            $table.='</ul></nav>';
            return $table;
        }
    }