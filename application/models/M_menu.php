<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_menu extends CI_Model {

	
	public function getMenuByRole()
	{	
		$this->db->select('a.id_role, a.id_menu_bo, b.nm_menu, 
			b.url, b.aktif, b.id_parent, b.icon as icon' );
		$this->db->from('m_role_menu a');
		$this->db->join('m_menu_bo b' , 'a.id_menu_bo = b.id_menu_bo', 'LEFT');
		$this->db->where('id_role', $this->session->userdata('id_role'));
		$this->db->where('a.aktif', 1);
		$this->db->where('b.aktif', 1);
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
			
			$html .= '<ul class="navigation-menu">';

			foreach ($menu['parents'][$parent] as $itemId) 
			{
				
				if (!isset($menu['parents'][$itemId])) {
					
					$html .= '<li>';

					if ($menu['menus'][$itemId]->url == "#") {
						$html .= '<li class="has-submenu"><a href="#">
								<i class="'.$menu['menus'][$itemId]->icon.'"></i>'.$menu['menus'][$itemId]->nm_menu.'</a>';
					}else{
						$html .= '<li class="has-submenu"><a href="' .base_url(). $menu['menus'][$itemId]->url .'">
								<i class="'.$menu['menus'][$itemId]->icon.'"></i>'.$menu['menus'][$itemId]->nm_menu.'</a>';
					}

                    /*$html .= '<a href="' .base_url(). $menu['menus'][$itemId]->url . '">';
                    $html .= '<i class="mdi mdi-view-dashboard"></i>'.$menu['menus'][$itemId]->nm_menu.'</a>';*/

                    $html .= '</li>';

				}

				if (isset($menu['parents'][$itemId])) {

					/*$html .= '<ul class="submenu">';*/

					if ($menu['menus'][$itemId]->url == "#") {
						$html .= '<li class="has-submenu"><a href="#">
								<i class="'.$menu['menus'][$itemId]->icon.'"></i>'.$menu['menus'][$itemId]->nm_menu.'</a>';
					}else{
						$html .= '<li class="has-submenu"><a href="' .base_url(). $menu['menus'][$itemId]->url .'">
								<i class="'.$menu['menus'][$itemId]->icon.'"></i>'.$menu['menus'][$itemId]->nm_menu.'</a>';
					}
					


					$html .= $this->build_parent_menu2($itemId, $menu);
					$html .= '</li>';
					/*$html .= '<ul>';*/
				}

			}

			$html .= '</ul>';
		}

		return $html;
	}

	function build_parent_menu2($parent, $menu)
	{
		$html = "";

		if (isset($menu['parents'][$parent])) {
			
			$html .= '<ul class="submenu">';

			foreach ($menu['parents'][$parent] as $itemId) 
			{
				
				if (!isset($menu['parents'][$itemId])) {
					
					$html .= '<li>';

					if ($menu['menus'][$itemId]->url == "#") {
						$html .= '<a href="#">';
                    	$html .= $menu['menus'][$itemId]->nm_menu.'</a>';
					}else{
						$html .= '<a href="' .base_url(). $menu['menus'][$itemId]->url . '">';
                    	$html .= $menu['menus'][$itemId]->nm_menu.'</a>';

					}
                   
                    $html .= '</li>';

				}

				if (isset($menu['parents'][$itemId])) {

					/*$html .= '<ul class="submenu">';*/

					if ($menu['menus'][$itemId]->url == "#") {
						$html .= '<li class="has-submenu"><a href="#">
							  '.$menu['menus'][$itemId]->nm_menu.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>';
					}else{
						$html .= '<li class="has-submenu"><a href="' .base_url(). $menu['menus'][$itemId]->url .'">
							  '.$menu['menus'][$itemId]->nm_menu.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>';

					}

					


					$html .= $this->build_parent_menu2($itemId, $menu);
					$html .= '</li>';
					/*$html .= '<ul>';*/
				}

			}

			$html .= '</ul>';
		}

		return $html;
	}
	


}