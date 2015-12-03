<?php
require_once 'viewmodels/ViewModel.php';
require_once 'utils/string.php';

class Error_ViewModel extends ViewModel
{
    /**
     * @var MorpheusPetsData data model
     */
    private $data;

    /**
     * User_ViewModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data = MorpheusPetsData::getInstance();
    }

    public function renderFailSearch()
    {
        $view_data[ 'page_title' ]         = 'User Not Found';
        $view_data[ 'js' ]                 = '<script src="js/error_page.js"></script>';

        $view_data[ 'not_found_username' ] = $_POST['search'];

        $this->renderTemplate( 'templates/header.php', $view_data );
        $this->renderTemplate( 'templates/error_view.php', $view_data );
        $this->renderTemplate( 'templates/footer.php', $view_data );
    }

    public function renderUserNotExist()
    {
        $view_data[ 'page_title' ]         = 'User Not Found';
        $view_data[ 'js' ]                 = '<script src="js/error_page.js"></script>';

        $view_data[ 'userIdNotFound' ] = $_GET['profileId'];

        $this->renderTEmplate('templates/header.php', $view_data );
        $this->renderTemplate( 'templates/error_view.php', $view_data );
        $this->renderTEmplate( 'templates/footer.php', $view_data);
    }
}
