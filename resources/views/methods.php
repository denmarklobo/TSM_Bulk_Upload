<?php
namespace App\Controllers;
use CodeIgniter\Controller;
 
class IntranetPages extends BaseController{
 
    public function __construct(){
 
        $this->BaseModel = model('App\Models\BaseModel');
        $this->User_model = model('App\Models\User_model');
        $this->Home_model = model('App\Models\Home_model');
        $this->IntranetPages_model = model('App\Models\IntranetPages_model');
    }//End Function
 
    public function getBusinessSoftware(){
 
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = "business-software";
 
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Business Software Apps'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_ExternalBusinessSoftwareApps'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
       
        //Data for Page
        $category1Data = $this->IntranetPages_model->getBusinessSoftware();
 
        echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
        echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
        echo view('intranet/parts/common/header.php');
        echo view('intranet/pages/others/'.$page.'.php', ['category1Data' => $category1Data]);
        echo view('intranet/parts/common/footer.php');
        echo view('parts/common/default-script.php');
        echo view('parts/common/closing-html.php');
    }//End Function
 
    public function companyStatistics(){
 
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = "company_statistics";
 
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Company Statistics'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_CompanyStatistics'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
 
        $StatisticsID = $this->request->getGet('sid');
       
 
        echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
        echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
        echo view('intranet/parts/common/header.php');
        echo view('intranet/pages/others/'.$page.'.php', ['StatisticsID' => $StatisticsID]);
        echo view('intranet/parts/common/footer.php');
        echo view('parts/common/default-script.php');
        echo view('parts/common/closing-html.php');
    }//End Function
 
    public function getcontribute(){
 
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = "contribute";
 
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Contribute'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_Contribute'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
       
        //Data for Page
        $contributeData = $this->IntranetPages_model->getContribute($companyID);
        //var_dump($contributeData);
 
        echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
        echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
        echo view('intranet/parts/common/header.php');
        echo view('intranet/pages/others/'.$page.'.php', ['contributeData' => $contributeData]);
        echo view('intranet/parts/common/footer.php');
        echo view('parts/common/default-script.php');
        echo view('parts/common/closing-html.php');
    }//End Function
 
    public function showAllNotification(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = 'notification';
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Notification'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_Notification'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
 
        echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
        echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
        echo view('intranet/parts/common/header.php');
        echo view('intranet/pages/others/'.$page.'.php');
        echo view('intranet/parts/common/footer.php');
        echo view('parts/common/default-script.php');
        echo view('parts/common/closing-html.php');
    }//End Function
 
    public function commonWebsiteLinks(){
 
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = "common-website-links";
 
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Common Website Links'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_CommonWebsiteLinks'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
       
        //Data for Page
        $commonwebsitelinksData = $this->IntranetPages_model->getCommonWebsiteLinks();
 
        echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
        echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
        echo view('intranet/parts/common/header.php');
        echo view('intranet/pages/others/'.$page, ['commonwebsitelinksData' => $commonwebsitelinksData]);
        echo view('intranet/parts/common/footer.php');
        echo view('parts/common/default-script.php');
        echo view('parts/common/closing-html.php');
    }//End Function
 
    public function search(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = 'search';
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Search'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_Search'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
 
        $companyID = $this->request->getGet('cmyid');
        $search_val = $this->request->getGet('search_val');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
       
        //Data for Page
        $searchData = $this->IntranetPages_model->getSearchResults($companyID, $search_val);
       
        // var_dump($searchData);
 
        echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
        echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
        echo view('intranet/parts/common/header.php');
        echo view('intranet/pages/others/'.$page.'.php', ['searchData' => $searchData]);
        echo view('intranet/parts/common/footer.php');
        echo view('parts/common/default-script.php');
        echo view('parts/common/closing-html.php');
    }//End Function
 
    public function archive(){
 
        $id = $this->request->getPost('id');
        $result = $this->IntranetPages_model->fileArchive($id);
        return $result;
    }//End Function
 
    public function restore(){
 
        $id = $this->request->getPost('id');
        $result = $this->IntranetPages_model->fileRestore($id);
        return $result;
    }//End Function
 
    public function contacts(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = 'contacts';
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Contacts'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_Contacts'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/contact/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
 
        echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
        echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
        echo view('intranet/parts/common/header.php');
        echo view('intranet/pages/contact/'.$page.'.php');
        echo view('intranet/parts/common/footer.php');
        echo view('parts/common/default-script.php');
        echo view('parts/common/closing-html.php');
    }//End Function
 
    public function businessSoftwareApps(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = 'business-software';
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Business Software & Apps'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_BusinessSoftware&Apps'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
 
        echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
        echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
        echo view('intranet/parts/common/header.php');
        echo view('intranet/pages/others/'.$page.'.php');
        echo view('intranet/parts/common/footer.php');
        echo view('parts/common/default-script.php');
        echo view('parts/common/closing-html.php');
    }//End Function
 
    public function careers(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = 'careers';
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Careers'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_Careers'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
 
     
        $userDetails = $this->User_model->getUserData();
 
        $employee_id = $userDetails['employee_code'];
 
        echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
        echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
        echo view('intranet/parts/common/header.php');
        echo view('intranet/pages/others/'.$page.'.php', ['employee_id' => $employee_id]);
        echo view('intranet/parts/common/footer.php');
        echo view('parts/common/default-script.php');
        echo view('parts/common/closing-html.php');
    }
 
    public function getEmployeeData(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }  
        $postData = $this->request->getVar();
 
        $pageData = $this->IntranetPages_model->getEmployeeData($postData);
 
        return json_encode($pageData);
    }
 
    public function getHiringPositions(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }    
 
        $pageData = $this->IntranetPages_model->getHiringPositions($postData);
 
        return $pageData;
    }
 
    public function submitApplicant(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }    
 
        $postData =  $this->request->getVar();  
        //var_dump($postData);
        $files = $_FILES['files'];
 
        //Data for Page
        $pageData = $this->IntranetPages_model->submitApplicant($postData, $files);
 
        return $pageData;
    }//End Function
 
    public function getrsUploadPages(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = "tsm-notes-upload";
 
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'TSM Notes Upload'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_TSMNotesUpload'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
       
        $pageData = $this->IntranetPages_model->getTSMNotesPage($companyID);
   
        if($pageData["has_access"] == true){
            echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
            echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
            echo view('intranet/parts/common/header.php');
            echo view('intranet/pages/others/'.$page.'.php', ['category1Data' => $category1Data]);
            echo view('intranet/parts/common/footer.php');
            echo view('parts/common/default-script.php');
            echo view('parts/common/closing-html.php');
        }else if($pageData["has_access"] == false){
            echo view('intranet/pages/access-error.html');
        }
    }
 
    public function submitTSMNotes(){
 
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }  
        $files = $_FILES['files']['tmp_name'];
        $result = $this->IntranetPages_model->submitTSMNotes($files);
 
        return $result;
       
    }//End Function
 
    public function getYearofServicePages(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = "year-service";
 
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Year of Service'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_TSMNotesUpload'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
       
        $pageData = $this->IntranetPages_model->getYearofServiceAcess($companyID);
   
        if($pageData["has_access"] == true){
            echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
            echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
            echo view('intranet/parts/common/header.php');
            echo view('intranet/pages/others/'.$page.'.php');
            echo view('intranet/parts/common/footer.php');
            echo view('parts/common/default-script.php');
            echo view('parts/common/closing-html.php');
        }else if($pageData["has_access"] == false){
            echo view('intranet/pages/access-error.html');
        }
    }
 
    public function getYearOfServiceRecords(){
 
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }    
 
        $result = $this->IntranetPages_model->getYearOfServiceRecords();
 
        return $result;
       
    }//End Function
 
 
    public function getBirthdayPages(){
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }
 
        $page = "employee-birthday";
 
        $pageHeadData = array(
            'siteName' => 'Dunbrae Connect',
            'pageTitle' => 'Employee Birthday'
        );
 
        $this->pageHeaderData['pageTitle'] = $pageHeadData['pageTitle']; // For breadcrumbs
        $pageBodyData = array (
            'bodyClass' => 'Intranet_EmployeeBirthday'
        );
 
        if( !file_exists(APPPATH.'Views/intranet/pages/others/'.$page.'.php') ){
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
 
        $companyID = $this->request->getGet('cmyid');
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
       
        $pageData = $this->IntranetPages_model->getBirthdayAcess($companyID);
   
        if($pageData["has_access"] == true){
            echo view('parts/common/head.php', ['pageHeadData' => $pageHeadData, 'pageHeaderData'=> $this->pageHeaderData]);
            echo view('intranet/parts/common/navigation.php', ['companyIntranet' => $companyIntranet, 'pageBodyData' => $pageBodyData]);
            echo view('intranet/parts/common/header.php');
            echo view('intranet/pages/others/'.$page.'.php');
            echo view('intranet/parts/common/footer.php');
            echo view('parts/common/default-script.php');
            echo view('parts/common/closing-html.php');
        }else if($pageData["has_access"] == false){
            echo view('intranet/pages/access-error.html');
        }
    }
 
    public function getEmployeeBirthdayRecords(){
 
        if ($_SESSION['userdata']['employee_code']=='') {  
            return redirect()->to(base_url().'/');
        }    
 
        $postData = $this->request->getVar();
        $result = $this->IntranetPages_model->getEmployeeBirthdayRecords($postData);
 
        return $result;
       
    }//End Function
}
?>
 
<?php
namespace App\Models;
use CodeIgniter\Model;
 
class IntranetPages_model extends Model{
    protected $db;
 
    public function __construct(){
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->BaseModel = model('App\Models\BaseModel');
        $this->Home_model = model('App\Models\Home_model');
        $this->User_model = model('App\Models\User_model');
    }//End
   
 
    public function getBusinessSoftware(){
        $sql = "SELECT page_id, page_name, page_url, page_icon FROM tbl_int_page WHERE page_type = 'Sub Navigation' AND status = '1' AND parent_id= '2'";
        $query = $this->BaseModel->db->query($sql);
        $results = $query->getResultArray();
 
        $data = array();
        foreach ($results as $result){
            $data[] = [
                "page_id" => $result['page_id'],
                "page_name" => $result['page_name'],
                "page_url" => $result['page_url'],
                "page_icon" => $result['page_icon'],
            ];
        }
        return $data;
    }//End
 
    public function getContribute(){
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
        $userDetails = $this->User_model->getUserData($companyID);
        $accessRights = $this->User_model->getGeneralAccessRights($userDetails['employee_code']);
       
        $department_dashboard_id = $companyIntranet['department_dashboard_id'];
        $company_id = $companyIntranet['company_id'];
        $id_no = $userDetails['employee_code'];
 
        $access_levels = array();
 
        foreach($accessRights as $rights){
            array_push($access_levels, $rights['level']);
        }//
 
        $data = array();
 
        $getNotPublic = "SELECT page_id, page_name, page_type,  page_url, page_icon, public, access_rights FROM tbl_int_page
        WHERE parent_id = '149' AND (public != 'Yes' AND public != 'Primary Deparment' AND public != 'Public Company') AND status = '1'";
        $query = $this->BaseModel->db->query($getNotPublic, ['pageID' => $pageID]);
        $notPublic = $query->getResultArray();
 
        foreach ($notPublic as $result) {
            $sql = "SELECT track_id FROM tbl_int_page_permission WHERE page_id = '". $result['page_id'] ."' AND status = '1'";
            $query = $this->BaseModel->db->query($sql);
            $track_ids = $query->getResultArray();
 
            $track_array = array();
 
            foreach($track_ids as $track){
                array_push($track_array, $track['track_id']);
            }//
            if($result['public'] == 'Page Permission'){
                if(array_intersect($track_array, $access_levels)){
                    $data[] = [
                        "page_id" => $result['page_id'],
                        "page_name" => $result['page_name'],
                        "page_type" => $result['page_type'],
                        "page_url" => $result['page_url'],
                        "page_icon" => $result['page_icon']
                    ];
                }
            }//
            else{
                continue;
            }//elif
        }//for
        return $data;
    }
 
 
    public function getCommonWebsiteLinks(){
        $sql = "SELECT page_id, page_name, page_url, page_icon FROM tbl_int_page WHERE page_type = 'Common Website Links' AND status = '1'";
        $query = $this->BaseModel->db->query($sql);
        $results = $query->getResultArray();
 
        $data = array();
        foreach ($results as $result){
            $data[] = [
                "page_id" => $result['page_id'],
                "page_name" => $result['page_name'],
                "page_url" => $result['page_url'],
                "page_icon" => $result['page_icon'],
            ];
        }
        return $data;
    }//End
 
    public function getSearchResults($companyID, $search_val){
        $userDetails = $this->User_model->getUserData();
        $accessRights = $this->User_model->getGeneralAccessRights($userDetails['employee_code']);
 
        $access_levels = array();
 
        //get user's access rights
        foreach($accessRights as $rights){
            array_push($access_levels, $rights['level']);
        }//
 
        $sql = "SELECT level_id FROM tbl_int_account_level_access WHERE id_no = '".$userDetails['employee_code']."' AND status = '1'";
        $query = $this->BaseModel->db->query($sql);
        $level_access = $query->getResultArray();
 
        //get user's file level access
        foreach($level_access as $level){
            array_push($access_levels, $level['level_id']);
        }//
           
        $data = array();
        $data['employees_search'] = array();
        $data['files_search'] = array();
        $data['files_search_archive'] = array();
        $data['announcement_search'] = array();
        $data['knowledgebase_search'] = array();
        $data['search_val'] = $search_val;
 
        $sql = "SELECT tbl_int_account.first_name, tbl_int_account.middle_name, tbl_int_account.last_name, tbl_int_account.id_no,
            tbl_int_account.company_email, tbl_int_account.profile_photo, tbl_int_position.position_id, tbl_int_position.position_title
            FROM tbl_int_account
            LEFT JOIN tbl_int_position
            ON tbl_int_account.position_id=tbl_int_position.position_id
            WHERE (
                    ( (tbl_int_account.first_name LIKE CONCAT('%', :search_val:,'%')) OR (tbl_int_account.last_name LIKE CONCAT('%', :search_val:,'%')) OR (tbl_int_account.id_no LIKE CONCAT('%', :search_val:,'%')) )
                    OR ( (tbl_int_position.position_title LIKE CONCAT('%', :search_val:,'%')) )
                    )
            AND tbl_int_account.status='1'";
 
        $query = $this->BaseModel->db->query($sql, ['search_val' => $search_val]);
        $results = $query->getResultArray();
 
        foreach ($results as $result) {
            if($result['company_email'] == '' || $result['company_email'] == NULL){
                $result['company_email'] = "No work email";
            }
   
            if($result['number'] == ''){
                $result['number'] = "No number";
            }
   
            $data['employees_search'][] = [
                "id_no" => $result['id_no'],
                "first_name" => $result['first_name'],
                "middle_name" => $result['middle_name'],
                "last_name" => $result['last_name'],
                "company_email" => $result['company_email'],
                "profile_photo" => $result['profile_photo'],
                "number" => $result['number'],
                "department_name" => $result['department_name'],
                "department_id" => $result['department_id'],
                "position_id" => $result['position_id'],
                "position_title" => $result['position_title']
            ];
        }
 
        $sql = "SELECT parent_id, file_id, file_type, file_name, file_title, file_description, tags, public, company_id, created_by, date_created, status FROM tbl_int_file WHERE file_title LIKE CONCAT('%', :search_val:,'%') AND file_type = 'Document-Centre' ORDER BY file_id DESC";
 
        $query = $this->BaseModel->db->query($sql, ['search_val' => $search_val]);
        $files = $query->getResultArray();
 
        foreach($files as $file){
            $has_page_permission = false;
            $sql = "SELECT track_id FROM tbl_int_page_permission WHERE page_id = '". $file['parent_id'] ."' AND status = '1'";
            $query = $this->BaseModel->db->query($sql);
            $track_ids = $query->getResultArray();
           
            $track_array = array();
 
            foreach($track_ids as $track){
                array_push($track_array, $track['track_id']);
            }//
           
            if($file['public'] == 'Page Permission' && array_intersect($track_array, $access_levels) && $file['company_id'] == $companyID ){
                $has_page_permission = true;
            }
               
            if( ($file['public'] == 'Public Company' && $file['company_id'] == $companyID) || ($file['public'] == 'Yes') || ($has_page_permission) ){
                if($file['status'] == 1 || $file['status'] == '1') {
                    $data['files_search'][] = [
                        "file_id" => $file['file_id'],
                        "file_type" => $file['file_type'],
                        "file_name" => $file['file_name'],
                        "file_title" => $file['file_title'],
                        "file_description" => $file['file_description'],
                        "date_created" => date('M j, Y g:i A', strtotime($file['date_created'])),
                        "tags" => $file['tags'],
                        "public" => $file['public'],
                        "contributed_id" => $file['created_by'],
                        "contributed_by" => $this->User_model->getFullName($file['created_by'])
                    ];
                } else {
                    $data['files_search_archive'][] = [
                        "file_id" => $file['file_id'],
                        "file_type" => $file['file_type'],
                        "file_name" => $file['file_name'],
                        "file_title" => $file['file_title'],
                        "file_description" => $file['file_description'],
                        "date_created" => date('M j, Y g:i A', strtotime($file['date_created'])),
                        "tags" => $file['tags'],
                        "public" => $file['public'],
                        "contributed_id" => $file['created_by'],
                        "contributed_by" => $this->User_model->getFullName($file['created_by'])
                    ];
                }
               
            }
        }
 
        $sql = "SELECT tbl_int_announcement.announcement_id, tbl_int_announcement.announcement_type, tbl_int_announcement.title, tbl_int_announcement.content, tbl_int_announcement.start_date, tbl_int_announcement.end_date, tbl_int_announcement.date_created,
        tbl_int_announcement.created_by, tbl_int_account.status
        FROM tbl_int_announcement
        INNER JOIN tbl_int_announcement_company_permission ON tbl_int_announcement.announcement_id=tbl_int_announcement_company_permission.announcement_id
        INNER JOIN tbl_int_account ON tbl_int_account.id_no=tbl_int_announcement.created_by
        WHERE tbl_int_announcement.title LIKE CONCAT('%', :search_val:,'%') AND tbl_int_announcement_company_permission.company_id = :companyID: AND ( tbl_int_announcement.status = '1' OR  tbl_int_announcement.status = 'Approved' ) AND tbl_int_announcement_company_permission.status = '1' ORDER BY date_created DESC";
        $query = $this->BaseModel->db->query($sql, ['search_val' => $search_val, 'companyID' => $companyID]);
        $announcements = $query->getResultArray();
 
        foreach($announcements as $ann){
            $sql = "SELECT announcement_media_id, media_type, media_path FROM tbl_int_announcement_media WHERE announcement_id=".$ann['announcement_id']." AND status='1'";
            $query = $this->BaseModel->db->query($sql);
            $media = $query->getResultArray();
           
            $data['announcement_search'][] = [
                "announcement_id" => $ann['announcement_id'],
                "announcement_type" => $ann['announcement_type'],
                "title" => $ann['title'],
                "content" => $ann['content'],
                "start_date" => $ann['start_date'],
                "end_date" => $ann['end_date'],
                'date_created' => $ann['date_created'],
                "created_by" => $ann['created_by'],
                "contributed_by" => $this->User_model->getFullName($ann['created_by']),
                "author_status" => $ann['status'],
                'media' => $media
            ];
        }
 
        $sql = "SELECT parent_id, file_id, file_type, file_name, file_title, tags, public, company_id, created_by, date_created FROM tbl_int_file WHERE (file_title LIKE CONCAT('%', :search_val:,'%') OR file_description LIKE CONCAT('%', :search_val:,'%')) AND file_type = 'Knowledge-Base' AND status = '1'";
 
        $query = $this->BaseModel->db->query($sql, ['search_val' => $search_val]);
        $knowledgebase = $query->getResultArray();
 
        foreach($knowledgebase as $document){
            $data['knowledgebase_search'][] = [
                "file_id" => $document['file_id'],
                "file_type" => $document['file_type'],
                "file_name" => $document['file_name'],
                "file_title" => $document['file_title'],
                "date_created" => date('M j, Y g:i A', strtotime($document['date_created'])),
                "tags" => $document['tags'],
                "public" => $document['public'],
                "contributed_id" => $document['created_by'],
                "contributed_by" => $this->User_model->getFullName($document['created_by'])
            ];
        }
 
        return $data;
    }//End
 
    public function fileArchive($id) {
        $sql = "UPDATE tbl_int_file
                SET status = :status:
                WHERE file_id = :id:
            ";
           
        $bind = [
            'status' => 2,
            'id' => $id,
        ];
 
        $query = $this->db->query($sql, $bind);
        return $id;
    }
 
    public function fileRestore($id) {
        $sql = "UPDATE tbl_int_file
                SET status = :status:
                WHERE file_id = :id:
            ";
           
        $bind = [
            'status' => 1,
            'id' => $id,
        ];
 
        $query = $this->db->query($sql, $bind);
        return $id;
    }
   
    public function getLevelData($trackID){
        $sql = "SELECT * FROM `tbl_int_level` WHERE level_id=:trackID: ";
        $query = $this->BaseModel->db->query($sql, ['trackID' => $trackID]);
        $result = $query->getRowArray();
 
        $data = [
            "group_level" => $result['group_level'],
            "level_name" => $result['name'],
            "legend_symbol" => $result['legend_symbol'],
        ];
        return $data;
    }//End
 
    public function getHiringPositions(){
        $sql = "SELECT tbl_hrms_personnel_requisition.requisition_id, tbl_hrms_careers.position_id, tbl_hrms_careers.careers_id, tbl_hrms_careers.created_by, tbl_hrms_careers.date_created, tbl_hrms_careers.status,
        tbl_int_position.position_title, tbl_int_position.position_overview, tbl_int_position.sacq, tbl_int_position.communication
        FROM tbl_hrms_careers
        INNER JOIN tbl_hrms_personnel_requisition
        ON tbl_hrms_personnel_requisition.position_type_id = tbl_hrms_careers.position_id
        INNER JOIN tbl_int_position
        ON tbl_hrms_careers.position_id = tbl_int_position.position_id
        WHERE tbl_hrms_careers.status = '1'";
        $query = $this->BaseModel->db->query($sql);
        $results = $query->getResultArray();
             
        if($results == null){
            echo 'No result found.';
        }else{
            foreach($results as $result){
 
                $specific_objectives = "SELECT attribute_value_one
                FROM tbl_gen_attribute_one    
                WHERE attribute_type = 'specific objectives' AND track_id = ".$result['position_id']." AND status = '1'";
                $query = $this->BaseModel->db->query($specific_objectives);
                $objective_results = $query->getResultArray();  
       
                $experiences = "SELECT attribute_value_one, attribute_value_two
                FROM tbl_gen_attribute_two    
                WHERE attribute_type = 'Skills & Experience - Education' OR attribute_type = 'Skills & Experience - Experience' AND track_id = ".$result['position_id']." AND status = '1'";
                $query = $this->BaseModel->db->query($experiences);
                $experience_results = $query->getResultArray();  
 
                echo '<div class="accordion accordion-light accordion-svg-icon position_title" id="accordionMain'.$result['requisition_id'].'" data-attribute-position="'.$result['position_id'].'" data-requisition="'.$result['requisition_id'].'">';
                    echo '<div class="card">';    
                        echo '<div class="card-header" id="headingMain'.$result['requisition_id'].'">';
                                echo '<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseMain'.$result['requisition_id'].'" aria-expanded="false" aria-controls="V">';
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">';
                                        echo '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">';
                                            echo '<polygon points="0 0 24 0 24 24 0 24"></polygon>';
                                            echo '<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>';
                                            echo '<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>';
                                        echo '</g>';
                                    echo '</svg> '.$result['position_title'].'';
                                echo '</div>';  
                        echo '</div>';
                        echo '<div id="collapseMain'.$result['requisition_id'].'" class="collapse" aria-labelledby="headingMain'.$result['requisition_id'].'" data-parent="#accordionMain'.$result['requisition_id'].'">';
                            echo '<div class="card-body">';
                                 echo '<div class="accordion accordion-light accordion-svg-icon" id="objectiveMain'.$result['requisition_id'].'">';
                                    echo '<div class="card">';
                                        echo '<div class="card-header" id="objectHeading'.$result['requisition_id'].'">';
                                            echo '<div class="card-title collapsed" data-toggle="collapse" data-target="#objectCollapse'.$result['requisition_id'].'" aria-expanded="false" aria-controls="objectCollapse'.$result['requisition_id'].'">';
                                                echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">';
                                                    echo '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">';
                                                        echo '<polygon points="0 0 24 0 24 24 0 24"></polygon>';
                                                        echo '<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>';
                                                        echo '<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>';
                                                    echo '</g>';
                                                echo '</svg> Specific Objectives';
                                            echo '</div>';
                                        echo '</div>';
                                        echo '<div id="objectCollapse'.$result['requisition_id'].'" class="collapse" aria-labelledby="objectHeading'.$result['requisition_id'].'" data-parent="#objectiveMain'.$result['requisition_id'].'" style="">';
                                            echo '<div class="card-body">';
                                                foreach($objective_results as $obj){
                                                    echo '<div class="kt-section__desc text-muted blockquote-footer">'.$obj['attribute_value_one'].'</div>';
                                                }
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<div class="card">';
                                        echo '<div class="card-header" id="communicationHeading'.$result['requisition_id'].'">';
                                            echo '<div class="card-title collapsed" data-toggle="collapse" data-target="#communicationCollapse'.$result['requisition_id'].'" aria-expanded="false" aria-controls="communicationCollapse'.$result['requisition_id'].'">';
                                                echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">';
                                                    echo '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">';
                                                        echo '<polygon points="0 0 24 0 24 24 0 24"></polygon>';
                                                        echo '<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>';
                                                        echo '<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>';
                                                    echo '</g>';
                                                echo '</svg> Communication (regularly communicates with)';
                                            echo '</div>';
                                        echo '</div>';
                                        echo '<div id="communicationCollapse'.$result['requisition_id'].'" class="collapse" aria-labelledby="communicationHeading'.$result['requisition_id'].'" data-parent="#objectiveMain'.$result['requisition_id'].'" style="">';
                                            echo '<div class="card-body">';
                                                    echo '<div class="kt-section__desc text-muted blockquote-footer">'.$result['communication'].'</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                     echo '<div class="card">';
                                        echo '<div class="card-header" id="skillsHeading'.$result['requisition_id'].'">';
                                            echo '<div class="card-title collapsed" data-toggle="collapse" data-target="#skillsCollapse'.$result['requisition_id'].'" aria-expanded="false" aria-controls="skillsCollapse'.$result['requisition_id'].'">';
                                                echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">';
                                                    echo '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">';
                                                        echo '<polygon points="0 0 24 0 24 24 0 24"></polygon>';
                                                        echo '<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>';
                                                        echo '<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>';
                                                    echo '</g>';
                                                echo '</svg> Skills and Experience';
                                            echo '</div>';
                                        echo '</div>';
                                        echo '<div id="skillsCollapse'.$result['requisition_id'].'" class="collapse" aria-labelledby="skillsHeading'.$result['requisition_id'].'" data-parent="#objectiveMain'.$result['requisition_id'].'" style="">';
                                            echo '<div class="card-body">';
                                                foreach($experience_results as $skills){
                                                    echo '<div class="kt-section__desc text-muted blockquote-footer">'.$skills['attribute_value_one'].' ('.$skills['attribute_value_two'].')</div>';
                                                }
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<div class="card">';
                                        echo '<div class="card-header" id="sacqHeading'.$result['requisition_id'].'">';
                                            echo '<div class="card-title collapsed" data-toggle="collapse" data-target="#sacqCollapse'.$result['requisition_id'].'" aria-expanded="false" aria-controls="sacqCollapse'.$result['requisition_id'].'">';
                                                echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">';
                                                    echo '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">';
                                                        echo '<polygon points="0 0 24 0 24 24 0 24"></polygon>';
                                                        echo '<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>';
                                                        echo '<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>';
                                                    echo '</g>';
                                                echo '</svg> Skills, Abilitites, Compentecies and Qualitites';
                                            echo '</div>';
                                        echo '</div>';
                                        echo '<div id="sacqCollapse'.$result['requisition_id'].'" class="collapse" aria-labelledby="sacqHeading'.$result['requisition_id'].'" data-parent="#objectiveMain'.$result['requisition_id'].'" style="">';
                                            echo '<div class="card-body">';
                                                    echo '<div class="kt-section__desc text-muted blockquote-footer">'.$result['sacq'].'</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<button type="button" class="btn btn-bold btn-label-brand btn-sm mt-4" data-toggle="modal" data-target="#kt_modal_4">Apply Now</button>';
                                 echo '</div>';  
                            echo '</div>';
                        echo '</div>';  
                    echo '</div>';  
                echo '</div>';
            }
        }
    }
 
    public function submitTSMNotes($files)
    {
        $userDetails = $this->User_model->getUserData();
        $id_no = $userDetails['employee_code'];
 
        $milliseconds = round(microtime(true) * 1000);
        // THIS
        $filename = $milliseconds . '.csv';
        $destination = "uploads/tsm-notes-upload/" . $filename;
 
        $sql = "SELECT * FROM `tbl_tsm_employee_code` WHERE id_no = :id_no: AND status='1'";
        $query = $this->BaseModel->db->query($sql, ['id_no' => $id_no]);
        $results = $query->getResultArray();
 
        $data = array();
        foreach ($results as $Code) {
            $Code['tsm_employee_code'];
        }
 
        // THIS ALSO
        foreach ($files as $file) {
            if (!move_uploaded_file($file, $destination)) {
                echo "Error uploading $file";
            } else {
                $target_dir = "uploads/tsm-notes-upload/";
                $target_file = $target_dir . $filename;
                if (file_exists($target_file)) {
                    $file_data = fopen("uploads/tsm-notes-upload/" . $filename, 'r');
                    $milliseconds = round(microtime(true) * 1000);
                    $filename_new = 'tsm_job_note-' . $milliseconds . '.csv';
 
                    $open = fopen("uploads/tsm-notes-final/" . $filename_new, 'w');
 
                    fputcsv($open, array('JOB NUMBER', 'NOTES', 'USER'));
 
                    $firstIterationSkipped = false;
                    while ($row = fgetcsv($file_data)) {
                        if (!$firstIterationSkipped) {
                            $firstIterationSkipped = true;
                            continue;
                        }
                        $data = array(
                            array($row[0], $row[1], $Code['tsm_employee_code'])
                        );
 
                        foreach ($data as $csv) {
                            fputcsv($open, $csv);
                        }
 
                    }
                    fclose($open);
                }
 
 
                $subject = "XML:JOB NOTE";
                $message = 'This is automated email. Please do not reply.';
                $sender = 'automations@dunbraegroup.onmicrosoft.com';
                $attachments = 'https://connect.dunbraegroup.com/uploads/tsm-notes-final/'.$filename_new;
                $base64string = '';
 
                if ($attachments[0] != '') {
 
                    $arrContextOptions = array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                        ),
                    );
                    if ($file_attach = file_get_contents($attachments, false, stream_context_create($arrContextOptions))) {
                        $base64string = base64_encode($file_attach);
                    }
 
                }
 
                $res = '{
                "message": {
                    "subject": "' . $subject . '",
                    "body": {
                        "contentType": "Text",
                        "content": "' . $message . '"
                    },
                    "toRecipients": [
                        {
                            "emailAddress": {
                                "address": "tsmxml@globalfoodequipment.com.au"
                            }
                           
                        }
                       
                    ],
                    "attachments": [
                        {
                            "@odata.type": "#microsoft.graph.fileAttachment",
                            "name": "' . $filename . '",
                            "contentType": "textplain",
                            "contentBytes": "' . $base64string . '"
                        }
                        ]
                }
            }';
 
                $url = "https://graph.microsoft.com/v1.0/users/" . $sender . "/sendMail";
                $curl = curl_init();
 
                curl_setopt_array(
                    $curl,
                    array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $res,
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . $this->getToken('68981705-98d9-44f3-a72b-61c7cd3ef4fd', 'https://login.microsoftonline.com')
                        ),
                    )
                );
 
                $err = curl_error($curl);
                $response = curl_exec($curl);
 
                if ($err) {
                    echo "cURL error #:" . $err;
                }
 
                curl_close($curl);
            }
        }
 
    }
           
    //get token
    function getToken($tenant, $tokenUrl)
    {
        try {
 
            if ( $tenant !== '68981705-98d9-44f3-a72b-61c7cd3ef4fd') {
                echo json_encode(array(
                    'status' => 401,
                    'message' => 'Unauthorized.'
                ));
                die();
            }
 
            $curl = curl_init();
 
            curl_setopt_array($curl, array(
                CURLOPT_URL => $tokenUrl. '/' . $tenant. '/oauth2/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'grant_type=client_credentials&
                                        client_id=fa2fb323-21d0-4967-abe7-585013608b13&
                                        client_secret=z0w8Q~w8uQ_ZrLsr7fTKr3mWDb_Nw7d02caIhcKD&
                                        resource=https://graph.microsoft.com&
                                        scope=mail.read',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Cookie: fpc=ApC8whU-B7NIh0xKCsatOFfYg4p8AQAAAKz1rtsOAAAA; stsservicecookie=estsfd; x-ms-gateway-slice=estsfd'
                ),
            ));
 
 
            $err = curl_error($curl);
            $res= curl_exec($curl);
 
            if ($err) {
                echo "cURL error #:" . $err;
            } else {
                $response = json_decode($res);
            }
 
            curl_close($curl);
 
            if (isset($response->error)) {
                if ($response->error === 'unauthorized_client') {
                    echo json_encode(array('status' => 401, 'message' => $response->error_description));
                    die();
                }
            }else{
                return $response->access_token;
           
            }
 
           
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
           
 
    public function getTSMNotesPage($companyID){
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
        $userDetails = $this->User_model->getUserData();
        $accessRights = $this->User_model->getGeneralAccessRights($userDetails['employee_code']);
       
        $data = array();
        $access_levels = array();
 
        foreach($accessRights as $rights){
            array_push($access_levels, $rights['level']);
        }
 
        if(in_array('1402', $access_levels)){
            $data['has_access'] = true;
        }else{
            $data['has_access'] = false;
        }
   
        return $data;
    }//End
 
    public function getYearofServiceAcess($companyID){
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
        $userDetails = $this->User_model->getUserData();
        $accessRights = $this->User_model->getGeneralAccessRights($userDetails['employee_code']);
       
        $department_dashboard_id = $companyIntranet['department_dashboard_id'];
        $company_id = $companyIntranet['company_id'];
       
        $data = array();
        $access_levels = array();
 
        foreach($accessRights as $rights){
            array_push($access_levels, $rights['level']);
        }
 
        if( in_array('1001', $access_levels) || in_array('1002', $access_levels) || in_array('1003', $access_levels)){
            $data['has_access'] = true;
        }else{
            $data['has_access'] = false;
        }
   
        return $data;
    }//End
 
 
    public function getYearOfServiceRecords(){
            $sql = "SELECT id_no, profile_photo, first_name, middle_name, last_name, employment_date, TIMESTAMPDIFF(YEAR, employment_date, CURRENT_DATE) AS years, TIMESTAMPDIFF(MONTH, employment_date, CURRENT_DATE) % 12 AS months FROM tbl_int_account WHERE status = '1' AND company_location_id != '1' ORDER BY employment_date ASC";
            $query = $this->BaseModel->db->query($sql);
            $results = $query->getResultArray();
           
            $html = "<div class='kt-portlet__body'>";
            if( sizeof($results) > 0){
                $html .= "  <table class='table table-striped table-bordered table-hover' id='table_records'>";
                $html .= "      <thead>";
                $html .= "          <tr>";
                $html .= "              <td>ID #</td>";
                $html .= "              <td>Photo</td>";
                $html .= "              <td>Full Name</td>";
                $html .= "              <td>Date Hired</td>";
                $html .= "              <td>Length of Service</td>";  
                $html .= "          </tr>";
                $html .= "      </thead>";
                $html .= "      <tbody>";
                foreach($results as $result){
                    $date_hired = date('M d, Y', strtotime($result['employment_date']));
 
                    $html .= "<tr>";
                    $html .= "<td>".$result['id_no']."</td>";
                    $html .= "<td><img src='images/profile_photo/".$result['profile_photo']."' style='display:block;margin:auto;width:36px;' /></td>";
                    $html .= "<td><a href='/intranet/contacts/employees/employee?cmyid=2&eid=".$result['id_no']."'>".$result['last_name'].", ".$result['first_name']." ".$result['middle_name']."</a></td>";
                    $html .= "<td>".$date_hired."</td>";
                    $html .= "<td>".$result['years']." years & ".$result['months']." months </td>";
                    $html .= "</tr>";
                }
                $html .= "      </tbody>";
                $html .= "  </table>";
            }else{
                $html .= 'No data yet.';
            }
            $html .= "</div>";
               
            return $html;
    }
 
    public function getBirthdayAcess($companyID){
        $companyIntranet = $this->Home_model->getCompanyIntranetData($companyID);
        $userDetails = $this->User_model->getUserData();
        $accessRights = $this->User_model->getGeneralAccessRights($userDetails['employee_code']);
       
        $department_dashboard_id = $companyIntranet['department_dashboard_id'];
        $company_id = $companyIntranet['company_id'];
       
        $data = array();
        $access_levels = array();
 
        foreach($accessRights as $rights){
            array_push($access_levels, $rights['level']);
        }
 
        if( in_array('1001', $access_levels) || in_array('1002', $access_levels) || in_array('1003', $access_levels)){
            $data['has_access'] = true;
        }else{
            $data['has_access'] = false;
        }
   
        return $data;
    }//End
 
 
    public function getEmployeeBirthdayRecords($postData){
            $month = $postData['date'];
            $start_month = date($month.'-01');
            $end_month = date($month.'-t');
            $sql = "SELECT id_no, profile_photo, first_name, middle_name, last_name, DATE_FORMAT(birth_date,'%M %d, %Y') AS birthday FROM tbl_int_account WHERE `status` = '1' AND company_location_id != '1' AND DATE_FORMAT(birth_date,'%m-%d') BETWEEN :start_month: AND :end_month: ORDER BY DAY(birth_date) ASC";
            $query = $this->BaseModel->db->query($sql, ['start_month' => $start_month, 'end_month' => $end_month]);
            $results = $query->getResultArray();
           
            $html = "<div class='kt-portlet__body'>";
            if( sizeof($results) > 0){
                $html .= "  <table class='table table-striped table-bordered table-hover' id='table_records'>";
                $html .= "      <thead>";
                $html .= "          <tr>";
                $html .= "              <td>ID #</td>";
                $html .= "              <td>Photo</td>";
                $html .= "              <td>Full Name</td>";
                $html .= "              <td>Birthday</td>";  
                $html .= "          </tr>";
                $html .= "      </thead>";
                $html .= "      <tbody>";
                foreach($results as $result){
 
                    $html .= "<tr>";
                    $html .= "<td>".$result['id_no']."</td>";
                    $html .= "<td><img src='images/profile_photo/".$result['profile_photo']."' style='display:block;margin:auto;width:36px;' /></td>";
                    $html .= "<td><a href='/intranet/contacts/employees/employee?cmyid=2&eid=".$result['id_no']."'>".$result['last_name'].", ".$result['first_name']." ".$result['middle_name']."</a></td>";
                    $html .= "<td>".$result['birthday']."</td>";
                    $html .= "</tr>";
                }
                $html .= "      </tbody>";
                $html .= "  </table>";
            }else{
                $html .= 'No data yet.';
            }
            $html .= "</div>";  
               
            return $html;
    }
 
 
    public function getEmployeeData($posData){
        $sql = "SELECT account_id, first_name, middle_name, last_name, company_email, birth_date, employment_date, employment_status, gender, honorary_title, nickname
        FROM tbl_int_account  
        WHERE status = '1' AND id_no = :id_no:";
        $query = $this->BaseModel->db->query($sql, ['id_no' => $posData['employee_id']]);
        $result = $query->getRowArray();
 
        $sql = "SELECT number
        FROM tbl_gen_contacts  
        WHERE status = '1' AND track_id = :track_id: AND contact_type = 'Mobile Number'";
        $query = $this->BaseModel->db->query($sql, ['track_id' => $result['account_id']]);
        $mobile_number = $query->getRowArray();
         
        $data = [
         "account_id" => $result['account_id'],
         "first_name" => $result['first_name'],
         "middle_name" => $result['middle_name'],
         "last_name" => $result['last_name'],
         "company_email" => $result['company_email'],
         "birth_date" => date('F j, Y', strtotime($result['birth_date'])),
         "employment_date" => date('F j, Y', strtotime($result['employment_date'])),
         "employment_status" => $result['employment_status'],
         "gender" => $result['gender'],
         "title" => $result['honorary_title'],
         "nickname" => $result['nickname'],
         "mobile_number" => $mobile_number['number']
        ];
        return $data;
    }
 
    public function submitApplicant($postData, $files){
        $userDetails = $this->User_model->getUserData();
        $created_by = $userDetails['employee_code'];  
 
        $sql = "INSERT INTO `tbl_hrms_applicant` (`requisition_id`, `reason_for_leaving`, `created_by`, `created_date`, `status`)
        VALUES (:requisition_id:, :reason_for_leaving:, :created_by:, :created_date:, :status:)";
 
        $add = $this->BaseModel->db->query($sql, [
            'requisition_id' => $postData['requisition_id'],  
            'reason_for_leaving' => $postData['reason_for_leaving'],  
            'created_by' => $created_by,
            'created_date' => $this->BaseModel->dateTimeNow,
            'status' => 'Applying'
        ]);
        $lastID = $this->BaseModel->db->insertID();
 
        if($add){
            $sql = "INSERT INTO `tbl_gen_person_info` (`track_type`, `track_id`, `first_name`, `middle_name`, `last_name`, `nickname`, `horonry_title`, `type`, `gender`, `date_of_birth`, `created_by`, `created_date`, `status`)
            VALUES (:track_type:, :track_id:, :first_name:, :middle_name:, :last_name:, :nickname:, :horonry_title:, :type:, :gender:, :date_of_birth:, :created_by:, :created_date:, :status:)";
 
            $add = $this->BaseModel->db->query($sql, [
                'track_type' => 'tbl_hrms_applicant',
                'track_id' => $lastID,
                'first_name' => $postData['first_name'],
                'middle_name' => $postData['middle_name'],  
                'last_name' => $postData['last_name'],
                'nickname' => $postData['nickname'],
                'horonry_title' => $postData['title'],  
                'type' => 'Applicant',  
                'gender' => $postData['gender'],  
                'date_of_birth' => date('Y-m-d', strtotime($postData['birthdate'])),
                'created_by' => $created_by,
                'created_date' => $this->BaseModel->dateTimeNow,
                'status' => '1'
            ]);
 
            $sql = "INSERT INTO `tbl_gen_emails` (`track_type`, `track_id`, `email_type`, `email`, `created_by`, `created_date`, `status`)
            VALUES (:track_type:, :track_id:, :email_type:, :email:, :created_by:, :created_date:, :status:)";
   
            $addEmail = $this->BaseModel->db->query($sql, [
                'track_type' => 'tbl_hrms_applicant',
                'track_id' =>  $lastID,
                'email_type' => 'Comapny Email',
                'email' => $postData['email'],  
                'created_by' => $created_by,
                'created_date' => $this->BaseModel->dateTimeNow,
                'status' => '1'
            ]);    
 
            $sql = "INSERT INTO `tbl_gen_contacts` (`track_type`, `track_id`, `contact_type`, `number`, `created_by`, `created_date`, `status`)
            VALUES (:track_type:, :track_id:, :contact_type:, :number:, :created_by:, :created_date:, :status:)";
   
            $addMobilePhone = $this->BaseModel->db->query($sql, [
                'track_type' => 'tbl_hrms_applicant',
                'track_id' =>  $lastID,
                'contact_type' => 'Mobile Phone Number',
                'number' => $postData['mobile_phone'],  
                'created_by' => $created_by,
                'created_date' => $this->BaseModel->dateTimeNow,
                'status' => '1'
            ]);  
 
            $addHomePhone = $this->BaseModel->db->query($sql, [
                'track_type' => 'tbl_hrms_applicant',
                'track_id' =>  $lastID,
                'contact_type' => 'Home Phone Number',
                'number' => $postData['home_phone'],  
                'created_by' => $created_by,
                'created_date' => $this->BaseModel->dateTimeNow,
                'status' => '1'
            ]);  
 
        }
        if($add){
            //loop through each file  
            foreach($files['name'] as $file => $file_name) {
                $milliseconds = round(microtime(true) * 1000);
                $path_filename = str_replace('~', '_', $file);
                $path_filename = str_replace("'", '_', $path_filename);
                $path_filename = str_replace('/', '_', $path_filename);
                $file_label = $lastID.'-'.$path_filename.'-'.$milliseconds.'-'.$counter.'.jpg';
                $destination = "uploads/applicant-resume/".$file_label;
 
                $sql = "INSERT INTO `tbl_gen_attachment` (`track_type`, `track_id`, `attachment_type`, `file_label`, `file_name`, `created_by`, `created_date`, `status`)
                VALUES (:track_type:, :track_id:, :attachment_type:, :file_label:, :file_name:, :created_by:, :created_date:, :status:)";
 
                $addFile = $this->BaseModel->db->query($sql, [
                    'track_type' => 'tbl_hrms_applicant',
                    'track_id' => $lastID,
                    'attachment_type' => 'Resume',
                    'file_label' => $file_label,
                    'file_name' => $file_name,
                    'created_by' => $created_by,
                    'created_date' => $this->BaseModel->dateTimeNow,
                    'status' => '1'
                ]);
                if($addFile){
                    //upload every file
                    if(!move_uploaded_file($files["tmp_name"][$file], $destination)){      
                        echo "Error uploading $file";
                    }  
                }else{
                    echo "Error inserting to media db $file";
                }
            }
        }
    }
}
?>