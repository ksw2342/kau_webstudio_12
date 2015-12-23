<?php

// loginAlreadyUser handler function...
/*
 * Method in charge to login user via ajax post request vars
 * @since 1.0
 * @return array jSon encoded array
 */
add_action('wp_ajax_cUs_CtCt_loginAlreadyUser', 'cUs_CtCt_loginAlreadyUser_callback');
function cUs_CtCt_loginAlreadyUser_callback() {
    
    $cUs_CtCt_api = new cUsComAPI_CtCt();
    $cUs_email = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
    $cUs_pass = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);
    
    //API CALL TO getAPICredentials
    $cUs_CtCt_API_credentials = $cUs_CtCt_api->getAPICredentials($cUs_email, $cUs_pass); //api hook;

    //print_r($cUs_CtCt_API_credentials);
    
    if($cUs_CtCt_API_credentials){
        $cUs_json = json_decode($cUs_CtCt_API_credentials);
        
        //SWITCH API STATUS RESPONSE
        switch ( $cUs_json->status  ) {
            case 'success':
                
                $cUs_API_Account    = $cUs_json->api_account;
                $cUs_API_Key        = $cUs_json->api_key;
                
                if(strlen(trim($cUs_API_Account)) && strlen(trim($cUs_API_Key))){
                    
                    $aryUserCredentials = array(
                        'API_Account' => $cUs_API_Account,
                        'API_Key'     => $cUs_API_Key
                    );
                    
                    
                    $cUs_CtCt_API_getKeysResult = $cUs_CtCt_api->getFormKeysData($cUs_API_Account, $cUs_API_Key); //api hook;

                    //print_r($cUs_CtCt_API_getKeysResult);
                    
                    //$old_options = get_option('contactus_settings'); //GET THE OLD OPTIONS
                    
                    $cUs_jsonKeys = json_decode($cUs_CtCt_API_getKeysResult);
                
                    if($cUs_jsonKeys->status == 'success' ){
                        
                        $postData = array( 'email' => $cUs_email);
                        update_option('cUs_CtCt_settings_userData', $postData);
                        
                        $cUs_CtCt_deeplinkview = $cUs_CtCt_api->get_deeplink( $cUs_jsonKeys->data );
                        
                        // get a default deeplink
                        update_option('cUs_CtCt_settings_default_deep_link_view', $cUs_CtCt_deeplinkview ); // DEFAULT FORM KEYS

                        //print_r($cUs_jsonKeys->data);

                        foreach ($cUs_jsonKeys->data as $oForms => $oForm) {
                            if ($oForm->default == 1 && cUs_CtCt_allowedFormType($oForm->form_type)){ //GET DEFAULT FORM KEY
                               $defaultFormKey = $oForm->form_key;
                               $form_type = $oForm->form_type;
                               $deeplinkview   = $oForm->deep_link_view;
                               $defaultFormId  = $oForm->form_id;
                               break;
                            }
                        } 
                            
                        if(!strlen($defaultFormKey)){
                                //echo 2; //NO ONE NEWSLETTER FORM
                                
                                $aryResponse = array(
                                    'status' => 2,
                                    'cUs_API_Account' 	=> $cUs_API_Account,
                                    'cUs_API_Key' 	=> $cUs_API_Key,
                                    'deep_link_view'	=> $cUs_CtCt_deeplinkview
                                );
                                
                               
                        }else{
                            
                            $aryFormOptions = array('tab_user' => 1,'cus_version' => 'tab'); //DEFAULT SETTINGS / FIRST TIME
                            
                            update_option('cUs_CtCt_FORM_settings', $aryFormOptions );//UPDATE FORM SETTINGS
                            update_option('cUs_CtCt_settings_form_key', $defaultFormKey);//DEFAULT FORM KEYS
                            update_option('cUs_CtCt_settings_form_keys', $cUs_jsonKeys); // ALL FORM KEYS
                            update_option('cUs_CtCt_settings_form_id', $defaultFormId); // DEFAULT FORM KEYS
                            update_option('cUs_CtCt_settings_default_deep_link_view', $deeplinkview); // DEFAULT FORM KEYS
                            update_option('cUs_CtCt_settings_userCredentials', $aryUserCredentials);
                            delete_option('cUs_CtCt_settings_userData');

                            $formSettings['form_status'] = 1;
                            $formSettings['form_key'] = $defaultFormKey;
                            $formSettings['form_id'] = $defaultFormId;
                            $formSettings['form_type'] = $form_type;
                            $formSettings['updated'] = 1;
                            update_option('cUs_CtCt_settings_form_'.$defaultFormId, $formSettings);
                            
                            $aryResponse = array('status' => 1);
                            
                        }

                            //echo 1;
                        
                    }else{
                        //{"status":"error","error":"No valid form keys"}
                        $aryResponse = array('status' => 3, 'message' => $cUs_jsonKeys->error);
                    } 
                    
                }else{
                    $aryResponse = array('status' => 3, 'message' => $cUs_json->error);
                }
                
                break;

            case 'error':
                $aryResponse = array('status' => 3, 'message' => $cUs_json->error);
                break;
        }
    }
    
    echo json_encode($aryResponse);
    
    die();
}


// cUs_CtCt_verifyCustomerEmail handler function...
/*
 * Method in charge to verify if the email exist via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUs_CtCt_verifyCustomerEmail', 'cUs_CtCt_verifyCustomerEmail_callback');
function cUs_CtCt_verifyCustomerEmail_callback() {
    
    if ( !strlen(filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL)) ){      echo 'Missing/Invalid Email, is required field';   die();
    }else{
        
        $cUs_CtCt_api = new cUsComAPI_CtCt(); //CONTACTUS.COM API

        $cUs_CtCt_API_EmailResult = $cUs_CtCt_api->verifyCustomerEmail(filter_input(INPUT_POST, 'email')); //EMAIL VERIFICATION
        if($cUs_CtCt_API_EmailResult) {
            $cUs_CtCt_jsonEmail = json_decode($cUs_CtCt_API_EmailResult);
            
            switch ($cUs_CtCt_jsonEmail->result){
                case 0 :
                    echo 'true';
                    break;
                case 1 :
                    echo 'false';
                    break;
            }
            
        }else{
            echo 'Unfortunately there has being an error during the application, please try again';
            exit();
        }
         
    }

    //echo json_encode($aryResponse);

    die();
}


// cUs_CtCt_createCustomer handler function...
/*
 * Method in charge to create a contactus.com user via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUs_CtCt_createCustomer', 'cUs_CtCt_createCustomer_callback');
function cUs_CtCt_createCustomer_callback() {
    
    $cUs_CtCt_userData = get_option('cUs_CtCt_settings_userData'); //get the saved user data
    
    if      (  !strlen( filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING) ) ){      echo 'Missing First Name, is required field';      die();
    }elseif  ( !strlen( filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING) ) ){      echo 'Missing Last Name, is required field';       die();
    }elseif  ( !strlen( filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) ) ){      echo 'Missing/Invalid Email, is required field';   die();
    }elseif  ( !strlen( filter_input(INPUT_POST, 'website', FILTER_SANITIZE_STRING) ) ){    echo 'Missing Website, is required field';         die();
    }else{
        
        $cUs_CtCt_api = new cUsComAPI_CtCt(); //CONTACTUS.COM API
        
        $postData = array(
            'fname' => filter_input(INPUT_POST, 'first_name'),
            'lname' => filter_input(INPUT_POST, 'last_name'),
            'email' => filter_input(INPUT_POST, 'email'),
            'website' => filter_input(INPUT_POST, 'website'),
            'phone' => preg_replace('/[^0-9]+/i', '', filter_input(INPUT_POST, 'phone')),
            'Template_Desktop_Form' => cUs_CtCt_FORM_TPL,
            'Template_Desktop_Tab' => cUs_CtCt_TAB_TPL,
            'Main_Category' => filter_input(INPUT_POST, 'CU_category',FILTER_SANITIZE_STRING),
            'Sub_Category' => filter_input(INPUT_POST, 'CU_subcategory',FILTER_SANITIZE_STRING),
            'Goals' => filter_input(INPUT_POST, 'CU_goals',FILTER_SANITIZE_STRING)
        );
        
        $cUs_CtCt_API_result = $cUs_CtCt_api->createCustomer($postData, filter_input(INPUT_POST, 'password'));
        if($cUs_CtCt_API_result) {

            $cUs_json = json_decode($cUs_CtCt_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    
                    echo 1;//GREAT
                    update_option('cUs_CtCt_settings_form_key', $cUs_json->form_key ); //finally get form key form contactus.com // SESSION IN
                    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
                        'tab_user'          => 1,
                        'cus_version'       => 'tab'
                    ); 
                    update_option('cUs_CtCt_settings_FORM', $aryFormOptions );//UPDATE FORM SETTINGS
                    update_option('cUs_CtCt_settings_userData', $postData);
                    
                    $cUs_API_Account    = $cUs_json->api_account;
                    $cUs_API_Key        = $cUs_json->api_key;
                    
                    $aryUserCredentials = array(
                        'API_Account' => $cUs_API_Account,
                        'API_Key'     => $cUs_API_Key
                    );
                    update_option('cUs_CtCt_settings_userCredentials', $aryUserCredentials);
                    
                    // ********************************
                    // get here the default deeplink after creating customer
                    $cUs_CtCt_API_getKeysResult = $cUs_CtCt_api->getFormKeysData($cUs_API_Account, $cUs_API_Key); //api hook;
                    
                    $cUs_jsonKeys = json_decode( $cUs_CtCt_API_getKeysResult );
                    $cUs_CtCt_deeplinkview = $cUs_CtCt_api->get_deeplink( $cUs_jsonKeys->data );
                    // get the default contact form deeplink
                    if( strlen( $cUs_CtCt_deeplinkview ) ){
                        update_option('cUs_CtCt_settings_default_deep_link_view', $cUs_CtCt_deeplinkview ); // DEFAULT FORM KEYS
                    }
                    // save the form id for this donation new user
                    update_option( 'cUs_CtCt_settings_form_id', $cUs_jsonKeys->data[0]->form_id );

                    $formSettings['form_status'] = 1;
                    $formSettings['form_key'] = $cUs_json->form_key;
                    $formSettings['form_id'] = $cUs_jsonKeys->data[0]->form_id;
                    $formSettings['form_type'] = $cUs_jsonKeys->data[0]->form_type;
                    $formSettings['updated'] = 1;
                    update_option('cUs_CtCt_settings_form_'.$cUs_jsonKeys->data[0]->form_id, $formSettings);

                break;

                case 'error':

                    if($cUs_json->error == 'Email exists'){
                        echo 2;//ALREDY CUS USER
                        //$cUs_CtCt_api->resetData(); //RESET DATA
                    }else{
                        //ANY ERROR
                        echo $cUs_json->error;
                        //$cUs_CtCt_api->resetData(); //RESET DATA
                    }
                    
                break;


            }
            
        }else{
             //echo 3;//API ERROR
             echo $cUs_CtCt_API_result;
             // $cUs_CtCt_api->resetData(); //RESET DATA
        }
        
         
    }
    
    die();
}


// LoadDefaultKey handler function...
/*
 * Method in charge to set default form key by user via ajax post request vars
 * @since 2.0
 * @return array jSon encoded array
 */
add_action('wp_ajax_cUs_CtCt_LoadDefaultKey', 'cUs_CtCt_LoadDefaultKey_callback');
function cUs_CtCt_LoadDefaultKey_callback() {
    
    $cUs_CtCt_api = new cUsComAPI_CtCt();
    $cUs_CtCt_userData = get_option('cUs_CtCt_settings_userData'); //get the saved user data
    $cUs_email = $cUs_CtCt_userData['email'];
    $cUs_pass = $cUs_CtCt_userData['credential'];
    
    $cUs_CtCt_API_result = $cUs_CtCt_api->getFormKeysData($cUs_email, $cUs_pass); //api hook;
    if($cUs_CtCt_API_result){
        $cUs_json = json_decode($cUs_CtCt_API_result);

        switch ( $cUs_json->status  ) {
            case 'success':
                
                foreach ($cUs_json->data as $oForms => $oForm) {
                    if ($oForms !='status' && $oForm->form_type == 0 && $oForm->default == 1){//GET DEFAULT NEWSLETTER FORM KEY
                       $defaultFormKey = $oForm->form_key;
                    }
                }
                
                update_option('cUs_CtCt_settings_form_key', $defaultFormKey);
                
                echo 1;
                break;

            case 'error':
                echo $cUs_json->error;
                //$cUs_CtCt_api->resetData(); //RESET DATA
                break;
        }
    }
    
    die();
}

// cUs_CtCt_setDefaulFormKey handler function...
/*
 * Method in charge to set default form key in all WP environment via ajax post request vars
 * @since 4.0.1
 * @return atring Status value array
 */
add_action('wp_ajax_cUs_CtCt_setDefaulFormKey', 'cUs_CtCt_setDefaulFormKey_callback');
function cUs_CtCt_setDefaulFormKey_callback() {
    
    if(isset($_REQUEST['formKey'])){
       update_option('cUs_CtCt_settings_form_key', $_REQUEST['formKey']);
       echo 1;//GREAT
    }
    
    die();
}


/*
 * Method in charge to set default form key in all WP environment via ajax post request vars
 * @since 4.0.1
 * @return atring Status value array
 */
add_action('wp_ajax_cUs_CtCt_setDefaulFormKeyByID', 'cUs_CtCt_setDefaulFormKeyByID_callback');
function cUs_CtCt_setDefaulFormKeyByID_callback() {

    if(isset($_POST['form_id'])){
       unset($_POST['action']);
       update_option('cUs_CtCt_settings_form_'.$_POST['form_id'], $_POST);
        $aryResponse = array('status' => 1);
    }

    echo json_encode($aryResponse);

    die();
}

/*
 * Method in charge to set default form key in all WP environment via ajax post request vars
 * @since 4.0.1
 * @return atring Status value array
 */
add_action('wp_ajax_cUs_CtCt_setPageSettings', 'cUs_CtCt_setPageSettings_callback');
function cUs_CtCt_setPageSettings_callback() {

    if(isset($_POST['page_id'])){
        unset($_POST['action']);

        $pageID = $_POST['page_id'];
        $pageSettings = get_post_meta( $pageID, 'cUs_CtCt_FormByPage_settings', true );

        $pageSettings['form_key'] = $_REQUEST['form-key'];

        if($_REQUEST['cus_version'] == 'tab'){
            $pageSettings['tab_user'] = $_REQUEST['form_status'];
            $pageSettings['form_status'] = $_REQUEST['form_status'];
            $pageSettings['cus_version'] = $_REQUEST['cus_version'];
        }

        if($_REQUEST['cus_version'] == 'inline'){

            $pageSettings['form_status_inline'] = $_REQUEST['form_status'];
            $pageSettings['cus_version_inline'] = $_REQUEST['form_version'];

            cUs_CtCt_inline_shortcode_cleaner_by_ID($pageID); //RESET SC
            if($_REQUEST['form_status']){
                cUs_CtCt_inline_shortcode_add($pageID); //ADDING SHORTCODE FOR INLINE PAGES
            }

        }

        update_post_meta($pageID, 'cUs_CtCt_FormByPage_settings', $pageSettings);//SAVE DATA ON POST TYPE PAGE METAS
        $aryResponse = array('status' => 1);
    }

    echo json_encode($aryResponse);

    die();
}

/*
 * Method in charge to set default form key in all WP environment via ajax post request vars
 * @since 4.0.1
 * @return atring Status value array
 */
add_action('wp_ajax_cUs_CtCt_setFormKeyByPage', 'cUs_CtCt_setFormKeyByPage_callback');
function cUs_CtCt_setFormKeyByPage_callback() {

    if(isset($_POST['pageID'])){
        unset($_POST['action']);

        $pageID = $_POST['pageID'];

        //print_r($_POST);
        //exit;



        if(!empty( $_REQUEST['form_key'] )){

            if($pageID == 'home'){
                $getHomePage    = get_option('cUs_CtCt_HOME_settings');
                $getHomePage['form_key'] = $_REQUEST['form_key'];
                update_option('cUs_CtCt_HOME_settings', $getHomePage);
            }else{
                $pageSettings = get_post_meta( $pageID, 'cUs_CtCt_FormByPage_settings', true );
                $pageSettings['form_key'] = $_REQUEST['form_key'];
                update_post_meta($pageID, 'cUs_CtCt_FormByPage_settings', $pageSettings);//SAVE DATA ON POST TYPE PAGE METAS
            }

            $aryThumbs = get_option('cUs_CtCt_settings_form_thumbs');
            $aryThumbs = $aryThumbs[ $_REQUEST['form_key'] ];
            $thumb = $aryThumbs['thumb'];
        }

        $aryResponse = array('status' => 1, 'thumb' => $thumb);
    }

    echo json_encode($aryResponse);

    die();
}

/*
 * Method in charge to set default form key in all WP environment via ajax post request vars
 * @since 4.0.1
 * @return atring Status value array
 */
add_action('wp_ajax_cUs_CtCt_setPageSettingsHome', 'cUs_CtCt_setPageSettingsHome_callback');
function cUs_CtCt_setPageSettingsHome_callback() {

    if(isset($_POST['page_id'])){
        unset($_POST['action']);

        $pageID = $_POST['page_id'];
        $getHomePage    = get_option('cUs_CtCt_HOME_settings');
        $thumb = '';

        if(!empty($getHomePage)){
           update_option('cUs_CtCt_HOME_settings', $getHomePage);
           $getHomePage    = get_option('cUs_CtCt_HOME_settings');
        }else{
            $getHomePage = array();
        }

        if(!empty( $_REQUEST['form-key'] )){
            $getHomePage['form_key'] = $_REQUEST['form-key'];
            $getHomePage['tab_user'] = $_REQUEST['tab_user'];
            $getHomePage['cus_version'] = $_REQUEST['cus_version'];

            update_option('cUs_CtCt_HOME_settings', $getHomePage);

            $aryThumbs = get_option('cUs_CtCt_settings_form_thumbs');
            $aryThumbs = $aryThumbs[ $_REQUEST['form-key'] ];
            $thumb = $aryThumbs['thumb'];
        }

        $aryResponse = array('status' => 1, 'thumb' => $thumb);
    }

    echo json_encode($aryResponse);

    die();
}

// cUs_CtCt_createCustomer handler function...
/*
 * Method in charge to update user form templates via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUs_CtCt_UpdateTemplates', 'cUs_CtCt_UpdateTemplates_callback');
function cUs_CtCt_UpdateTemplates_callback() {
    
    $cUs_CtCt_userData = get_option('cUs_CtCt_settings_userData'); //get the saved user data
    
    if      ( !strlen($cUs_CtCt_userData['email']) ){      echo 'Missing/Invalid Email, is required field';   die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Form']) ){    echo 'Missing Form Template';         die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Tab']) ){    echo 'Missing Tab Template';         die();
    }else{
        
        $cUs_CtCt_api = new cUsComAPI_CtCt(); //CONTACTUS.COM API
        $form_key       = get_option('cUs_CtCt_settings_form_key');
        $postData = array(
            'email' => $cUs_CtCt_userData['email'],
            'credential' => $cUs_CtCt_userData['credential'],
            'Template_Desktop_Form' => $_REQUEST['Template_Desktop_Form'],
            'Template_Desktop_Tab' => $_REQUEST['Template_Desktop_Tab']
        );
        
        $cUs_CtCt_API_result = $cUs_CtCt_api->updateFormSettings($postData, $form_key);
        if($cUs_CtCt_API_result) {

            $cUs_json = json_decode($cUs_CtCt_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUs_CtCt_api->resetData(); //RESET DATA
                break;


            }
            
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUs_CtCt_api->resetData(); //RESET DATA
        }
         
    }
    
    die();
}

/*
 * Method in charge to chage user form templates via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUs_CtCt_changeFormTemplate', 'cUs_CtCt_changeFormTemplate_callback');
function cUs_CtCt_changeFormTemplate_callback() {
    
    $cUs_CtCt_userData = get_option('cUs_CtCt_settings_userCredentials'); //get the saved user data
   
    if      ( !strlen($cUs_CtCt_userData['API_Account']) ){     echo 'Missing API Account';   die();
    }elseif  ( !strlen($cUs_CtCt_userData['API_Key']) ){         echo 'Missing Form Key';         die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Form']) ){    echo 'Missing Form Template';         die();
    }elseif  ( !strlen($_REQUEST['form_key']) ){    echo 'Missing Form Key';         die();
    }else{
        
        $cUs_CtCt_api = new cUsComAPI_CtCt(); //CONTACTUS.COM API
        $form_key = $_REQUEST['form_key'];
        
        $postData = array(
            'API_Account'       => $cUs_CtCt_userData['API_Account'],
            'API_Key'           => $cUs_CtCt_userData['API_Key'],
            'Template_Desktop_Form' => $_REQUEST['Template_Desktop_Form']
        );
        
        $cUs_CtCt_API_result = $cUs_CtCt_api->updateFormSettings($postData, $form_key);
        if($cUs_CtCt_API_result) {

            $cUs_json = json_decode($cUs_CtCt_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUs_CtCt_api->resetData(); //RESET DATA
                break;


            } 
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUs_CtCt_api->resetData(); //RESET DATA
        } 
        
         
    } 
    
    die();
}

/*
 * Method in charge to update user tab templates via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUs_CtCt_changeTabTemplate', 'cUs_CtCt_changeTabTemplate_callback');
function cUs_CtCt_changeTabTemplate_callback() {
    
    $cUs_CtCt_userData = get_option('cUs_CtCt_settings_userCredentials'); //get the saved user data
   
    if       ( !strlen($cUs_CtCt_userData['API_Account']) ){       echo 'Missing API Account';   die();
    }elseif  ( !strlen($cUs_CtCt_userData['API_Key']) ){           echo 'Missing Form Key';      die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Tab']) ){    echo 'Missing Tab Template';  die();
    }elseif  ( !strlen($_REQUEST['form_key']) ){                echo 'Missing Form Key';      die();
    }else{
        
        $cUs_CtCt_api = new cUsComAPI_CtCt(); //CONTACTUS.COM API
        $form_key = $_REQUEST['form_key'];
        
        $postData = array(
            'API_Account'       => $cUs_CtCt_userData['API_Account'],
            'API_Key'           => $cUs_CtCt_userData['API_Key'],
            'Template_Desktop_Tab' => $_REQUEST['Template_Desktop_Tab']
        );
        
        $cUs_CtCt_API_result = $cUs_CtCt_api->updateFormSettings($postData, $form_key);
        if($cUs_CtCt_API_result) {

            $cUs_json = json_decode($cUs_CtCt_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUs_CtCt_api->resetData(); //RESET DATA
                break;


            } 
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUs_CtCt_api->resetData(); //RESET DATA
        } 
        
         
    }
    
    die();
}



// save custom selected pages handler function...
/*
 * Method in charge to save form settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUs_CtCt_saveCustomSettings', 'cUs_CtCt_saveCustomSettings_callback');
function cUs_CtCt_saveCustomSettings_callback() {
    
    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
        'tab_user'          => $_REQUEST['tab_user'],
        'cus_version'       => $_REQUEST['cus_version']
    ); 
    update_option('cUs_CtCt_settings_FORM', $aryFormOptions );//UPDATE FORM SETTINGS
    
    cUs_CtCt_page_settings_cleaner();
    
    delete_option( 'cUs_CtCt_settings_inlinepages' );
    delete_option( 'cUs_CtCt_settings_tabpages' );
   
    
    die();
}

// save custom selected pages handler function...
/*
 * Method in charge to remove page settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUs_CtCt_deletePageSettings', 'cUs_CtCt_deletePageSettings_callback');
function cUs_CtCt_deletePageSettings_callback() {
    
    $pageID = $_REQUEST['pageID'];
    
    delete_post_meta($pageID, 'cUs_CtCt_FormByPage_settings');//reset values
    cUs_CtCt_inline_shortcode_cleaner_by_ID($pageID); //RESET SC
    
    $aryTabPages = get_option('cUs_CtCt_settings_tabpages');
    $aryTabPages = cUs_CtCt_removePage($pageID,$aryTabPages);
    update_option( 'cUs_CtCt_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            
    $aryInlinePages = get_option('cUs_CtCt_settings_inlinepages');
    $aryInlinePages = cUs_CtCt_removePage($pageID,$aryInlinePages);
    update_option( 'cUs_CtCt_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
    
    die();
}

// save custom selected pages handler function...
/*
 * Method in charge to update user page settings from page selection via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUs_CtCt_changePageSettings', 'cUs_CtCt_changePageSettings_callback');
function cUs_CtCt_changePageSettings_callback() {
    
    $pageID = $_REQUEST['pageID'];
    delete_post_meta($pageID, 'cUs_CtCt_FormByPage_settings');//reset values
    cUs_CtCt_inline_shortcode_cleaner_by_ID($pageID); //RESET SC
    $aryTabPages = get_option('cUs_CtCt_settings_tabpages');
    $aryInlinePages = get_option('cUs_CtCt_settings_inlinepages');
    
    switch ($_REQUEST['cus_version']){
        case 'tab':
            
            $tabUser = 1;
            
            $aryTabPages[] = $pageID;
            $aryTabPages = array_unique($aryTabPages);
            update_option('cUs_CtCt_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            
            if(!empty($aryInlinePages)){
                $aryInlinePages = cUs_CtCt_removePage($pageID,$aryInlinePages);
                update_option( 'cUs_CtCt_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
            }
            
            echo 1;
            
            break;
        case 'inline':
            
            $tabUser = 0;
            
            $aryInlinePages[] = $pageID;
            $aryInlinePages = array_unique($aryInlinePages);
            update_option( 'cUs_CtCt_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
            
            if(!empty($aryTabPages)){
                $aryTabPages = cUs_CtCt_removePage($pageID,$aryTabPages);
                update_option( 'cUs_CtCt_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            }
            
            cUs_CtCt_inline_shortcode_add($pageID); //ADDING SHORTCODE FOR INLINE PAGES
            
            echo 1;
            
            break;
    } 
    
    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
        'tab_user'          => $tabUser,
        'form_key'          => $_REQUEST['form_key'],   
        'cus_version'       => $_REQUEST['cus_version']
    );
    
    if($pageID != 'home'){
        update_post_meta($pageID, 'cUs_CtCt_FormByPage_settings', $aryFormOptions);//SAVE DATA ON POST TYPE PAGE METAS
    }else{
       update_option('cUs_CtCt_HOME_settings', $aryFormOptions );//UPDATE FORM SETTINGS
    }
    
    die();
}

/*
 * Method in charge to remove user guide
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUs_CtCt_disable_introjs', 'cUs_CtCt_disable_introjs_callback');
function cUs_CtCt_disable_introjs_callback() {
    update_option( 'cUs_CtCt_settings_intro_hints', 0); //UPDATE OPTIONS

    die();
}

/*
 * Method in charge to remove page settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
function cUs_CtCt_removePage($valueToSearch, $arrayToSearch){
    $key = array_search($valueToSearch,$arrayToSearch);
    if($key!==false){
        unset($arrayToSearch[$key]);
    }
    return $arrayToSearch;
}

// logoutUser handler function...
/*
 * Method in charge to remove wp options saved with this plugin via ajax post request vars
 * @since 1.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUs_CtCt_logoutUser', 'cUs_CtCt_logoutUser_callback');
function cUs_CtCt_logoutUser_callback() {
    
    $cUs_CtCt_api = new cUsComAPI_CtCt();
    $cUs_CtCt_api->resetData(); //RESET DATA
    
    delete_option( 'cUs_CtCt_settings_api_key' );
    delete_option( 'cUs_CtCt_settings_form_key' );
    delete_option( 'cUs_CtCt_settings_list_Name' );
    delete_option( 'cUs_CtCt_settings_list_ID' );
    
    echo 'Deleted.... User data'; //none list
    
    die();
}