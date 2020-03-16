<?php 
namespace Alaska_Model;

class View
{
	private $page;
	
	public function __construct($page = null)
	{
		$this->page = $page;
	}

	public function getView($datas = array()) /* Crée tableau pour pouvoir récupérer plusieurs variable GET */
	{
		// crée dynamiquement la variable après avoir parcouru $datas
		extract($datas);  // resultat : $chapter / $chapters / $comments / $comment

		$page = $this->page;
 		ob_start();
 		require VIEW.$page.'.php';
 		$content = ob_get_clean();
 		require VIEW.'template.php';
	}

	public function redirect($route)
	{
		header('Location:'.HOST.'index.php?page='.$route);
		exit;
	}

}
?>
