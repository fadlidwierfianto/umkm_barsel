<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mm extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	function get($table, $data = array(), $returnformat = 'rear'){
        if(!empty($data['select']))
            $this->db->select($data['select'],false);
        if(!empty($data['distinct']) AND $data['distinct'])
            $this->db->distinct();
        $table = $this->db->dbprefix($table);
		$this->db->from($table);
        /*
        $data['join'] = array(
                            array('table1', 'table.a = table1.a', 'left|right'),
                            array('table2', 'table.b = table2.b', 'left|right')
                        );
        */
        if(!empty($data['join']) AND is_array($data['join'])){
            foreach($data['join'] as $jjoin){
                //$jjoin[0] = isset($jjoin[0]) ? $jjoin[0] : '';
                $jjoin[1] = isset($jjoin[1]) ? $jjoin[1] : '';
                $jjoin[2] = isset($jjoin[2]) ? $jjoin[2] : '';
                $this->db->join($jjoin[0], $jjoin[1], $jjoin[2]);
            }
        }
        /*
        $data['where'] = array(
                            'id' => 'idnya',
                            'nama !=' => 'namanya'
                        );
        $data['where'] = array(
                            array('id', 'idnya'),
                            array('alamat !=', 'alamatnya')
                        );
        $data['where'] = "id = 'idnya' OR nama = 'namanya'";
        */
		if( !empty($data['where']) ){
            if(!empty($data['where'][0]) AND is_array($data['where'])){
                foreach($data['where'] as $wwhere){
                    if(isset($wwhere[1])){
                     $this->db->where($wwhere[0], $wwhere[1]);
                    } elseif(isset($wwhere[0])){
                     $this->db->where($wwhere[0]);
                    } else {
                     $this->db->where($wwhere);
                    }
                }
            } else if(is_array($data['where'])){
                foreach($data['where'] as $kwhere => $vwhere){
                    $this->db->where($kwhere, $vwhere);
                }
            } else {
                $this->db->where( $data['where'] );
            }
		}
		if( !empty($data['or_where']) ){
            if(isset($data['or_where'][0]) AND is_array($data['or_where'])){
                foreach($data['or_where'] as $wwhere){
                    $this->db->or_where($wwhere[0], $wwhere[1]);
                }
            } else if(is_array($data['or_where'])){
                foreach($data['or_where'] as $kwhere => $vwhere){
                    $this->db->or_where($kwhere, $vwhere);
                }
            }
		}
        /*
        $data['where_in'] = array(
                            'id' => array(),
                            'alamat' => array()
                        );
        $data['where_in'] = array(
                            array('id', array())),
                            array('alamat', array()))
                        );
        */
		if( !empty($data['where_in']) ){
            if(isset($data['where_in'][0]) AND is_array($data['where_in'])){
                foreach($data['where_in'] as $wwhere){
                    $this->db->where_in($wwhere[0], $wwhere[1]);
                }
            } else if(is_array($data['where_in'])){
                foreach($data['where_in'] as $kwhere => $vwhere){
                    $this->db->where_in($kwhere, $vwhere);
                }
            }
		}
		if( !empty($data['or_where_in']) ){
            foreach($data['or_where_in'] as $wwhere){
                $this->db->or_where_in($wwhere[0], $wwhere[1]);
            }
            if(isset($data['where_in'][0]) AND is_array($data['where_in'])){
                foreach($data['where_in'] as $wwhere){
                    $this->db->where_in($wwhere[0], $wwhere[1]);
                }
            } else if(is_array($data['where_in'])){
                foreach($data['where_in'] as $kwhere => $vwhere){
                    $this->db->where_in($kwhere, $vwhere);
                }
            }
		}
		if( !empty($data['where_not_in']) ){
            if(isset($data['where_not_in'][0]) AND is_array($data['where_not_in'])){
                foreach($data['where_not_in'] as $wwhere){
                    $this->db->where_not_in($wwhere[0], $wwhere[1]);
                }
            } else if(is_array($data['where_not_in'])){
                foreach($data['where_not_in'] as $kwhere => $vwhere){
                    $this->db->where_not_in($kwhere, $vwhere);
                }
            }
		}
		if( !empty($data['or_where_not_in']) ){
            if(isset($data['or_where_not_in'][0]) AND is_array($data['or_where_not_in'])){
                foreach($data['or_where_not_in'] as $wwhere){
                    $this->db->or_where_not_in($wwhere[0], $wwhere[1]);
                }
            } else if(is_array($data['or_where_not_in'])){
                foreach($data['or_where_not_in'] as $kwhere => $vwhere){
                    $this->db->or_where_not_in($kwhere, $vwhere);
                }
            }
		}
        /*
        $data['like'] = array(
                            array('nama', 'namanya', 'before|after|both'),
                            array('alamat', 'alamatnya', 'before|after|both')
                        );
        */
        if(!empty($data['like']) AND is_array($data['like'])){
            foreach($data['like'] as $llike){
                //$llike[0] = isset($llike[0]) ? $llike[0] : '';
                $llike[1] = isset($llike[1]) ? $llike[1] : '';
                $llike[2] = isset($llike[2]) ? $llike[2] : '';
                $this->db->like($llike[0], $llike[1], $llike[2]);
            }
        }
        if(!empty($data['or_like']) AND is_array($data['or_like'])){
            foreach($data['or_like'] as $llike){
                //$llike[0] = isset($llike[0]) ? $llike[0] : '';
                $llike[1] = isset($llike[1]) ? $llike[1] : '';
                $llike[2] = isset($llike[2]) ? $llike[2] : '';
                $this->db->or_like($llike[0], $llike[1], $llike[2]);
            }
        }
			
		if( !empty($data['limit']) )
			$this->db->limit( $data['limit'], (!empty($data['offset']) ? $data['offset']: '' ));
        /*
        $data['order'] = "nama asc, alamat desc";
        $data['order'] = array(
                            array('nama', 'asc'),
                            array('alamat', 'desc')
                        );
        */
		if( !empty($data['order']) ){
            if(is_array($data['order'])){
                foreach($data['order'] as $oorder){
                    $this->db->order_by($oorder[0], $oorder[1]);
                }
            } else {
                $this->db->order_by( $data['order'] );
            }
		}
			
		if (!empty($data['group_by']))
            $this->db->group_by($data['group_by']);
		$query	= $this->db->get();
        /*
        rear = result_array
        roar = row_array
        re = result
        ro = row
        */
        switch($returnformat){
            case 'rear' :
                return $query->result_array();
                break;
            case 'roar' :
                return $query->row_array();
                break;
            case 're' :
                return $query->result();
                break;
            case 'ro' :
                return $query->row();
                break;
        }
	}
	function count($table, $data = array()){
        $table = $this->db->dbprefix($table);
		$this->db->from($table);
        if(!empty($data['join']) AND is_array($data['join'])){
            foreach($data['join'] as $jjoin){
                //$jjoin[0] = isset($jjoin[0]) ? $jjoin[0] : '';
                $jjoin[1] = isset($jjoin[1]) ? $jjoin[1] : '';
                $jjoin[2] = isset($jjoin[2]) ? $jjoin[2] : '';
                $this->db->join($jjoin[0], $jjoin[1], $jjoin[2]);
            }
        }
		if( !empty($data['where']) ){
            if(!empty($data['where'][0]) AND is_array($data['where'])){
                foreach($data['where'] as $wwhere){
                  if(isset($wwhere[1]) AND $wwhere[1]){
                    $this->db->where($wwhere[0], $wwhere[1]);
                  } elseif(isset($wwhere[1])){
                    $this->db->where($wwhere[0], $wwhere[1]);
                  } else {
                    $this->db->where($wwhere[0]);
                  }
                }
            } else if(is_array($data['where'])){
                foreach($data['where'] as $kwhere => $vwhere){
                    $this->db->where($kwhere, $vwhere);
                }
            } else {
                $this->db->where( $data['where'] );
            }
		}
		if( !empty($data['or_where']) ){
            if(isset($data['or_where'][0]) AND is_array($data['or_where'])){
                foreach($data['or_where'] as $wwhere){
                    $this->db->or_where($wwhere[0], $wwhere[1]);
                }
            } else if(is_array($data['or_where'])){
                foreach($data['or_where'] as $kwhere => $vwhere){
                    $this->db->or_where($kwhere, $vwhere);
                }
            }
		}
		if( !empty($data['where_in']) ){
            if(isset($data['where_in'][0]) AND is_array($data['where_in'])){
                foreach($data['where_in'] as $wwhere){
                    $this->db->where_in($wwhere[0], $wwhere[1]);
                }
            } else if(is_array($data['where_in'])){
                foreach($data['where_in'] as $kwhere => $vwhere){
                    $this->db->where_in($kwhere, $vwhere);
                }
            }
		}
		if( !empty($data['or_where_in']) ){
            foreach($data['or_where_in'] as $wwhere){
                $this->db->or_where_in($wwhere[0], $wwhere[1]);
            }
            if(isset($data['where_in'][0]) AND is_array($data['where_in'])){
                foreach($data['where_in'] as $wwhere){
                    $this->db->where_in($wwhere[0], $wwhere[1]);
                }
            } else if(is_array($data['where_in'])){
                foreach($data['where_in'] as $kwhere => $vwhere){
                    $this->db->where_in($kwhere, $vwhere);
                }
            }
		}
		if( !empty($data['where_not_in']) ){
            if(isset($data['where_not_in'][0]) AND is_array($data['where_not_in'])){
                foreach($data['where_not_in'] as $wwhere){
                    $this->db->where_not_in($wwhere[0], $wwhere[1]);
                }
            } else if(is_array($data['where_not_in'])){
                foreach($data['where_not_in'] as $kwhere => $vwhere){
                    $this->db->where_not_in($kwhere, $vwhere);
                }
            }
		}
		if( !empty($data['or_where_not_in']) ){
            if(isset($data['or_where_not_in'][0]) AND is_array($data['or_where_not_in'])){
                foreach($data['or_where_not_in'] as $wwhere){
                    $this->db->or_where_not_in($wwhere[0], $wwhere[1]);
                }
            } else if(is_array($data['or_where_not_in'])){
                foreach($data['or_where_not_in'] as $kwhere => $vwhere){
                    $this->db->or_where_not_in($kwhere, $vwhere);
                }
            }
		}
        if(!empty($data['like']) AND is_array($data['like'])){
            foreach($data['like'] as $llike){
                //$llike[0] = isset($llike[0]) ? $llike[0] : '';
                $llike[1] = isset($llike[1]) ? $llike[1] : '';
                $llike[2] = isset($llike[2]) ? $llike[2] : ''; //both, after, before
                $this->db->like($llike[0], $llike[1], $llike[2]);
            }
        }
        if(!empty($data['or_like']) AND is_array($data['or_like'])){
            foreach($data['or_like'] as $llike){
                //$llike[0] = isset($llike[0]) ? $llike[0] : '';
                $llike[1] = isset($llike[1]) ? $llike[1] : '';
                $llike[2] = isset($llike[2]) ? $llike[2] : '';
                $this->db->or_like($llike[0], $llike[1], $llike[2]);
            }
        }
		return $this->db->count_all_results();
	}
    function save($table, $post, $data = array()){
        if(!empty($data)){
    		if( !empty($data['where']) ){
                if(!empty($data['where'][0]) AND is_array($data['where'])){
                    foreach($data['where'] as $wwhere){
                        $this->db->where($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['where'])){
                    foreach($data['where'] as $kwhere => $vwhere){
                        $this->db->where($kwhere, $vwhere);
                    }
                } else {
                    $this->db->where( $data['where'] );
                }
    		}
    		if( !empty($data['or_where']) ){
                if(isset($data['or_where'][0]) AND is_array($data['or_where'])){
                    foreach($data['or_where'] as $wwhere){
                        $this->db->or_where($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['or_where'])){
                    foreach($data['or_where'] as $kwhere => $vwhere){
                        $this->db->or_where($kwhere, $vwhere);
                    }
                }
    		}
    		if( !empty($data['where_in']) ){
                if(isset($data['where_in'][0]) AND is_array($data['where_in'])){
                    foreach($data['where_in'] as $wwhere){
                        $this->db->where_in($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['where_in'])){
                    foreach($data['where_in'] as $kwhere => $vwhere){
                        $this->db->where_in($kwhere, $vwhere);
                    }
                }
    		}
    		if( !empty($data['or_where_in']) ){
                if(isset($data['where_in'][0]) AND is_array($data['where_in'])){
                    foreach($data['where_in'] as $wwhere){
                        $this->db->where_in($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['where_in'])){
                    foreach($data['where_in'] as $kwhere => $vwhere){
                        $this->db->where_in($kwhere, $vwhere);
                    }
                }
    		}
    		if( !empty($data['where_not_in']) ){
                if(isset($data['where_not_in'][0]) AND is_array($data['where_not_in'])){
                    foreach($data['where_not_in'] as $wwhere){
                        $this->db->where_not_in($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['where_not_in'])){
                    foreach($data['where_not_in'] as $kwhere => $vwhere){
                        $this->db->where_not_in($kwhere, $vwhere);
                    }
                }
    		}
    		if( !empty($data['or_where_not_in']) ){
                if(isset($data['or_where_not_in'][0]) AND is_array($data['or_where_not_in'])){
                    foreach($data['or_where_not_in'] as $wwhere){
                        $this->db->or_where_not_in($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['or_where_not_in'])){
                    foreach($data['or_where_not_in'] as $kwhere => $vwhere){
                        $this->db->or_where_not_in($kwhere, $vwhere);
                    }
                }
    		}
            $table = $this->db->dbprefix($table);
            return $this->db->update($table, $post);
        } else {
            $table = $this->db->dbprefix($table);
    		$insert = $this->db->insert($table, $post);
            if( $return = $this->db->insert_id()){
                return $return;
            } else {
                return $insert;
            }
        }
    }
    function delete($table, $data = null){
        if(is_array($table)){
            $ntable = array();
            foreach($table as $vtable){
                $ntable[] = $this->db->dbprefix($vtable);
            }
            $table = $ntable;
        } else {
            $table = $this->db->dbprefix($table);
        }
        if(!empty($data)){
    		if( !empty($data['where']) ){
                if(!empty($data['where'][0]) AND is_array($data['where'])){
                    foreach($data['where'] as $wwhere){
                        $this->db->where($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['where'])){
                    foreach($data['where'] as $kwhere => $vwhere){
                        $this->db->where($kwhere, $vwhere);
                    }
                } else {
                    $this->db->where( $data['where'] );
                }
    		}
    		if( !empty($data['or_where']) ){
                if(isset($data['or_where'][0]) AND is_array($data['or_where'])){
                    foreach($data['or_where'] as $wwhere){
                        $this->db->or_where($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['or_where'])){
                    foreach($data['or_where'] as $kwhere => $vwhere){
                        $this->db->or_where($kwhere, $vwhere);
                    }
                }
    		}
    		if( !empty($data['where_in']) ){
                if(isset($data['where_in'][0]) AND is_array($data['where_in'])){
                    foreach($data['where_in'] as $wwhere){
                        $this->db->where_in($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['where_in'])){
                    foreach($data['where_in'] as $kwhere => $vwhere){
                        $this->db->where_in($kwhere, $vwhere);
                    }
                }
    		}
    		if( !empty($data['or_where_in']) ){
                if(isset($data['where_in'][0]) AND is_array($data['where_in'])){
                    foreach($data['where_in'] as $wwhere){
                        $this->db->where_in($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['where_in'])){
                    foreach($data['where_in'] as $kwhere => $vwhere){
                        $this->db->where_in($kwhere, $vwhere);
                    }
                }
    		}
    		if( !empty($data['where_not_in']) ){
                if(isset($data['where_not_in'][0]) AND is_array($data['where_not_in'])){
                    foreach($data['where_not_in'] as $wwhere){
                        $this->db->where_not_in($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['where_not_in'])){
                    foreach($data['where_not_in'] as $kwhere => $vwhere){
                        $this->db->where_not_in($kwhere, $vwhere);
                    }
                }
    		}
    		if( !empty($data['or_where_not_in']) ){
                if(isset($data['or_where_not_in'][0]) AND is_array($data['or_where_not_in'])){
                    foreach($data['or_where_not_in'] as $wwhere){
                        $this->db->or_where_not_in($wwhere[0], $wwhere[1]);
                    }
                } else if(is_array($data['or_where_not_in'])){
                    foreach($data['or_where_not_in'] as $kwhere => $vwhere){
                        $this->db->or_where_not_in($kwhere, $vwhere);
                    }
                }
    		}
        }
        return $this->db->delete($table);
    }
    function query($Q, $returnformat = 'rear'){
        $query = $this->db->query($Q);
        switch($returnformat){
            case 'rear' :
                return $query->result_array();
                break;
            case 'roar' :
                return $query->row_array();
                break;
            case 're' :
                return $query->result();
                break;
            case 'ro' :
                return $query->row();
                break;
        }
    }
    
 /***
 old pre
 heri.mardiansah@gmail.com
 ***/
	function insert( $table, $post = array() ) {
        $table = $this->db->dbprefix($table);
		$insert = $this->db->insert($table, $post);
        if( $return = $this->db->insert_id()){
            return $return;
        } else {
            return $insert;
        }
	}
    
    function insert_duplicate_update($table, $post, $update){
        $table = $this->db->dbprefix($table);
        $arrayKey = array_keys($post);
        $keys = implode(", ", $arrayKey);
        $values = implode("', '", $post);
        $q = "INSERT INTO `". $table ."` (". $keys .") VALUES ('". $values ."') ON DUPLICATE KEY UPDATE ". $update .";";
        $query = $this->db->query($q);
        return $query;
    }
    
    function insert_ignore($table, $post){
        $table = $this->db->dbprefix($table);
        $arrayKey = array_keys($post);
        $keys = implode(", ", $arrayKey);
        $values = implode("', '", $post);
        $q = "INSERT IGNORE INTO `". $table ."` (". $keys .") VALUES ('". $values ."')";
        $query = $this->db->query($q);
        return $query;
    }
    
    function insert_ignore_batch($table, $keys, $values){
        $table = $this->db->dbprefix($table);
        if(is_array($values)) $values = implode(", ", $values);
        $q = "INSERT IGNORE INTO `". $table ."` (". $keys .") VALUES ". $values ."";
        $query = $this->db->query($q);
        return $query;
    }
	
    function get_insert($table, $returnIndex, $where, $post = array()){
        $table = $this->db->dbprefix($table);
        if($data = $this->get_data($table, $where)){
            return $data[$returnIndex];
        } else {
            return $this->insert($table, $post);
        }
    }
    function run_query($query){
        return $this->db->query($query);
    }    
}
