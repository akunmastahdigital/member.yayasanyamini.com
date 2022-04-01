<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_akses extends CI_Model {

	
	public function getMenuByRole()
	{	
		$this->db->select('a.id_role, a.id_menu_bo, b.nm_menu, 
			b.url, a.aktif as aktif1, b.aktif as aktif2, b.id_parent' );
		$this->db->from('m_role_menu a');
		$this->db->join('m_menu_bo b' , 'a.id_menu_bo = b.id_menu_bo', 'LEFT');
		$this->db->where('id_role' , $this->uri->segment(3));
		
		$query = $this->db->get();


		$menu = array(
			'menu' => array(),
			'parents' => array() 
			);

		foreach ($query->result() as $row ) {
			
			$menu['menus'][$row->id_menu_bo] = $row;

			$menu['parents'][$row->id_parent][] = $row->id_menu_bo;

		}

		if ($menu) {
		
			$result = $this->build_parent_menu(0, $menu);
		
			return $result;

		}	else{

			return FALSE;
		}

	}

	function build_parent_menu($parent, $menu)
	{
		$html = "";

		if (isset($menu['parents'][$parent])) {
			
			$html .= '<ul class="collapsibleList" style="font-size:20px;">';

			foreach ($menu['parents'][$parent] as $itemId) 
			{
				
				if (!isset($menu['parents'][$itemId])) {
					
					$html .= '<li class = "">';
                    $html .= '<a class = "" >';
                    $html .= $menu['menus'][$itemId]->nm_menu.'</a>';

                     if ($menu['menus'][$itemId]->aktif1 == 1) {

                    	$html .= ' &nbsp;&nbsp;&nbsp;<input type="checkbox"  class="action" data-action="aktif" data-id_role="'.$menu['menus'][$itemId]->id_role.'" name="select_update[]"  checked data-id_menu_bo="'.$menu['menus'][$itemId]->id_menu_bo.'"> ';

                    	/*$html 	.= '<input class="action" data-action="aktif" data-id_menu_bo="'.$menu['menus'][$itemId]->id_role.'" type="checkbox" id="lbl-'.$menu['menus'][$itemId]->id_role.'" checked switch="none" >
                                            <label for="lbl-'.$menu['menus'][$itemId]->id_role.'" data-on-label="On"
                                                   data-off-label="Off"></label>';*/

                    	
                    }elseif($menu['menus'][$itemId]->aktif1 == 0){

                    	$html .= ' &nbsp;&nbsp;&nbsp;<input type="checkbox"  class="action" data-action="aktif" data-id_role="'.$menu['menus'][$itemId]->id_role.'" name="select_update[]" data-id_menu_bo="'.$menu['menus'][$itemId]->id_menu_bo.'"> ';
                    }
                    //$html .= ' &nbsp;&nbsp;&nbsp;<input type="hidden" class="select_update" name="id_menu_bo" value="'.$menu['menus'][$itemId]->id_menu_bo.'">';
                   
                    $html .= '</li>';

				}

				if (isset($menu['parents'][$itemId])) {

					
					$html .= '<li class="">';
					$html .= '<a class="" >
							 '.$menu['menus'][$itemId]->nm_menu.'</a>';
					
					 if ($menu['menus'][$itemId]->aktif1 == 1) {

                    	$html .= ' &nbsp;&nbsp;&nbsp;<input type="checkbox"  class="action" data-action="aktif" data-id_role="'.$menu['menus'][$itemId]->id_role.'" name="select_update[]"  checked data-id_menu_bo="'.$menu['menus'][$itemId]->id_menu_bo.'"> ';

                    	

                    }elseif($menu['menus'][$itemId]->aktif1 == 0){

                    	$html .= ' &nbsp;&nbsp;&nbsp;<input type="checkbox"  class="action" data-action="aktif" data-id_role="'.$menu['menus'][$itemId]->id_role.'" name="select_update[]" data-id_menu_bo="'.$menu['menus'][$itemId]->id_menu_bo.'" > ';

                    }
                    //$html .= ' &nbsp;&nbsp;&nbsp;<input type="hidden" class="select_update" name="id_menu_bo" value="'.$menu['menus'][$itemId]->id_menu_bo.'">';

					$html .= $this->build_parent_menu($itemId, $menu);
					$html .= '</li>';
					
				}

			}

			$html .= '</ul>';
		}

		return $html;
	}




	public function tampilMenuTree()
	{	
		$this->db->distinct();
		$this->db->select('a.id_role, a.id_menu_bo, b.nm_menu, 
			b.url, a.aktif as aktif1, b.aktif as aktif2, b.id_parent' );
		$this->db->from('m_role_menu a');
		$this->db->join('m_menu_bo b' , 'a.id_menu_bo = b.id_menu_bo', 'LEFT');
		$this->db->group_by('id_menu_bo');
		//$this->db->where('id_role' , $this->uri->segment(3));
		
		$query = $this->db->get();


		$menu = array(
			'menu' => array(),
			'parents' => array() 
			);

		foreach ($query->result() as $row ) {
			
			$menu['menus'][$row->id_menu_bo] = $row;

			$menu['parents'][$row->id_parent][] = $row->id_menu_bo;

		}

		if ($menu) {
		
			$result = $this->build_parent_menu1(0, $menu);
		
			return $result;

		}	else{

			return FALSE;
		}

	}

	function build_parent_menu1($parent, $menu)
	{
		$html = "";

		if (isset($menu['parents'][$parent])) {
			
			$html .= '<ul class="collapsibleList">';

			foreach ($menu['parents'][$parent] as $itemId) 
			{
				
				if (!isset($menu['parents'][$itemId])) {
					
					$html .= '<li class = "">';
                    $html .= '<a class = "" >';
                    $html .= $menu['menus'][$itemId]->nm_menu.'</a>';
                    $html .= '&nbsp;&nbsp;&nbsp;<button type="button" data-id="'.$menu['menus'][$itemId]->id_menu_bo.'"  data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-success m-b-5 tooltip-hover tooltipstered" title="edit"> 
											<i class="fa fa-pencil"></i> 
										</button>';

                    
                   
                    $html .= '</li>';

				}

				if (isset($menu['parents'][$itemId])) {

					
					$html .= '<li class="">';
					$html .= '<a class="" >
							 '.$menu['menus'][$itemId]->nm_menu.'</a>';
					 $html .= '&nbsp;&nbsp;&nbsp;<button type="button" data-id="'.$menu['menus'][$itemId]->id_menu_bo.'"  data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-success m-b-5 tooltip-hover tooltipstered" title="edit"> 
											<i class="fa fa-pencil"></i> 
										</button>';
					

					$html .= $this->build_parent_menu1($itemId, $menu);
					$html .= '</li>';
					
				}

			}

			$html .= '</ul>';
		}

		return $html;
	}

	


}