<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_record_client.php';

class api_record extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        // load event model
        if (! isset($this->Event))
        {
            $this->load->model('Event', '', TRUE);
        }

        if (! isset($this->Itinerary))
        {
            $this->load->model('Itinerary', '', TRUE);
        }

        if (! isset($this->User))
        {
            $this->load->model('User', '', TRUE);
        }

        if (! isset($this->Breakout))
        {
            $this->load->model('Breakout', '', TRUE);
        }

        if (! isset($this->Guest))
        {
            $this->load->model('Guest', '', TRUE);
        }

        if(! isset($this->Companion)){
            $this->load->model('Companion','',TRUE);
        }
        if (! isset($this->Role))
        {
            $this->load->model('Role', '', TRUE);
        }
        if (! isset($this->Activity_Preference))
        {
            $this->load->model('Activity_Preference', '', TRUE);
        }
        if (! isset($this->Activity_Preference_Option))
        {
            $this->load->model('Activity_Preference_Option', '', TRUE);
        }
        if (! isset($this->Attendee_Activity_Preference))
        {
            $this->load->model('Attendee_Activity_Preference', '', TRUE);
        }
        if (! isset($this->Map_Photo))
        {
            $this->load->model('Map_Photo', '', TRUE);
        }

        if (! isset($this->Presentation))
        {
            $this->load->model('Presentation', '', TRUE);
        }

        if (! isset($this->Presentation_Category))
        {
            $this->load->model('Presentation_Category', '', TRUE);
        }

        if (! isset($this->Content_Control))
        {
            $this->load->model('Content_Control', '', TRUE);
        }
    }

    /**
     * @method get
     * @param string category    // id parameter of type integer
     * @param string sort_field // the field to sort
     * @param string sort_order // ASC|DESC sort order
     * @param int page // the current page in the pagination
     * @param int per_page // the limit of rows per page
     * @return json/xml data
     */
    public function record_get()
    {

        $eventData = array();
        $eventData = $this->Event->getAllEvents();

        $itineraryData = array();
        $itineraryData = $this->Itinerary->getAllItineraries();

        $userData = array();
        $userData = $this->getAllUsers();

        //$breakoutData = array();
        //$breakoutData = $this->Breakout->getAllBreakouts();

        $guestData = array();
        $guestData = $this->Guest->getAllGuests();

        $roleData = array();
        $roleData = $this->Role->getAllRoles();


        $breakoutData = array();
        $breakoutData = $this->getAllBreakoutsWithUser();

        $contentControlData = array();
        $contentControlData = current($this->Content_Control->getLastUpdate());
        $arrResponse = array(
            'record' => array(
                'lastUpdate' => $contentControlData['last_update'],
                'events' => $eventData,
                'itineraries' => $itineraryData,
                'users' => $userData,
                'breakouts' => $breakoutData,
                'guests' => $guestData,
                'role' => $roleData,
            ),
        );
        $this->response($arrResponse);
    }

    private function getAllUsers(){
        $users = $this->User->getAllUsers();
        $tmpArray = array();
        foreach($users as $user){
            $tmpArray[$user['userID']] = $user;
        }
        return $tmpArray;
    }

    public function phpinfo_get(){
        echo phpinfo();
        exit();
    }

    /**
     * @method get
     * @param string category    // id parameter of type integer
     * @param string sort_field // the field to sort
     * @param string sort_order // ASC|DESC sort order
     * @param int page // the current page in the pagination
     * @param int per_page // the limit of rows per page
     * @return json/xml data
     */
    public function trecord_get()
    {
        //ini_set("zlib.output_compression", 4096);
        $allData = $this->getEverything();
        //die();

        //$eventData = array();
        //$eventData = $this->Event->getAllEvents(array('status'=>1));

        //$itineraryData = array();
        //$itineraryData = $this->Itinerary->getAllItineraries();

        $userData = array();
        $userData = $this->getAllUsers();
        $userData = $this->getUserTeams($userData);

        $eventAttendees = array();
        $eventAttendees = $this->getAllEventAttendees();

        //$breakoutData = array();
        //$breakoutData = $this->Breakout->getAllBreakouts();

        //$guestData = array();
        //$guestData = $this->Guest->getAllGuests();

        $roleData = array();
        //$roleData = $this->Role->getAllRoles();

        $companions = array();
        $companionsData = array();
        $companions = $this->Companion->getAllCompanions();

        foreach ($companions as $companion){
            $companionsData[$companion['user_id']] = $companion;
            //array_push($companionsData[$companion['user_id']],$companion);
        }

        //$companionsData = array();
        //$companionsData = $this->Companion->getAllCompanions();

        $optionsData = array();
        $options = $this->Activity_Preference_Option->getActivityPreferenceOptions();
        foreach ($options as $opt){
            if(!isset($optionsData[$opt['activityPreferenceID']])){
                $optionsData[$opt['activityPreferenceID']] = array($opt['activityPreferenceOptionID']=>$opt);
            }else{
                array_push($optionsData[$opt['activityPreferenceID']],$opt);
            }
        }

        //$breakoutData = array();
        //$breakoutData = $this->getAllBreakoutsWithUser();

        $contentControlData = array();
        $contentControlData = current($this->Content_Control->getLastUpdate());
        $arrResponse = array(
            'record' => array(
                'lastUpdate' => $contentControlData['last_update'],
                'users' => $userData,
                'companion'=> $companionsData,
                'event_attendees'=> $eventAttendees,
                'preferences_options' => $optionsData,
                'alldata' => $allData
            ),
        );

        $this->response($arrResponse);
    }

    private function getAllBreakoutsWithUser(){
        $breakoutData = array();
        $breakoutData = $this->Breakout->getAllBreakouts();

        foreach($breakoutData as $key => $breakoutDataInd):
            $allGuests = array();
            $allGuests = $this->Guest->getAllGuests(array('reference_id'=>$breakoutDataInd['breakoutID'], 'role_id'=>0));
            $breakoutData[$key]['guests'] = $allGuests;
            $allGuests = array();
            $allGuests = $this->Guest->getAllGuests(array('reference_id'=>$breakoutDataInd['breakoutID'], 'role_id'=>2));
            $breakoutData[$key]['speaker'] = $allGuests;
        endforeach;

        //yo::log($allGuests);

        return $breakoutData;
    }

    private function getEverything(){
        $eventData = array();
        $userData = $this->getAllUsers();
        $eventData = $this->Event->getAllEvents(array('status'=> '1'));
        $newEventData = array();
        foreach($eventData as $key=>$eventDataInd):
            $newEventData[$eventDataInd['eventID']] = $eventDataInd;

            $itineraryData = array();
            $itineraryData = $this->Itinerary->getAllItineraries(array($eventDataInd['eventID']));

            $newItineraryData = array();
            $itinerayIDList = array();
            if(count($itineraryData)>0){

                foreach($itineraryData as $keyy=>$itineraryDataInd):
                    //add speaker under itinerary
                    $itinerayIDList[] = $itineraryDataInd['itineraryID'];
                    $arrSpeakers = $arrTempSpeakers = array();
                    $searchOptions = array();
                    $searchOptions['role_id'] = 2;
                    $searchOptions['reference_id'] = $itineraryDataInd['itineraryID'];
                    $searchOptions['reference_type'] = 'agenda'; // itinerary - prev value
                    $arrSpeakers =  $this->Guest->getAllGuests($searchOptions);

                    $itineraryDataInd['speakers'] = '';
                    if (is_array($arrSpeakers) && isset($arrSpeakers)) {
                        foreach($arrSpeakers as $speaker) {
                            if ($speaker['user_id'] != 0 && array_key_exists($speaker['user_id'], $userData)) {
                                array_push($arrTempSpeakers, $userData[$speaker['user_id']]['first_name'] . " " .$userData[$speaker['user_id']]['last_name']);
                            }
                        }
                        $itineraryDataInd['speakers'] = implode(", ", $arrTempSpeakers);
                    }

                    $newItineraryData[$itineraryDataInd['itineraryID']] = $itineraryDataInd;
                    $breakoutData = array();
                    $breakoutData = $this->Breakout->getAllBreakouts(array('itinerary_id'=>$itineraryDataInd['itineraryID']));

                    $newBreakoutData = array();
                    if($breakoutData > 0){
                        foreach($breakoutData as $keyx => $breakoutDataInd):

                        //retrieve speakers
                        $arrSpeakers = $arrTempSpeakers = array();
                        $searchOptions = array();
                        $searchOptions['role_id'] = 2;
                        $searchOptions['reference_id'] = $breakoutDataInd['breakoutID'];
                        $searchOptions['reference_type'] = 'activity'; // breakout - prev value
                        $arrSpeakers =  $this->Guest->getAllGuests($searchOptions);

                        $breakoutDataInd['speakers'] = '';
                        if (is_array($arrSpeakers)) {
                            foreach($arrSpeakers as $speaker) {
                                if (array_key_exists($speaker['user_id'], $userData)) {
                                    array_push($arrTempSpeakers, $userData[$speaker['user_id']]['first_name'] . " " .$userData[$speaker['user_id']]['last_name']);
                                }
                            }
                            $breakoutDataInd['speakers'] = implode(",", $arrTempSpeakers);
                        }
                            $newBreakoutData[$breakoutDataInd['breakoutID']] = $breakoutDataInd;
                        endforeach;
                    }

                    $newItineraryData[$itineraryDataInd['itineraryID']]['breakout']=$newBreakoutData;
                endforeach;
                $newEventData[$eventDataInd['eventID']]['itinerary'] = $newItineraryData;
            }else{
                $newEventData[$eventDataInd['eventID']]['itinerary']=array();
            }
            //get all attendees with its itinerary and breakouts of the current event
            $attendees = array();
            $tmp_attendees = array();
            $tmp_attendees = $this->Guest->getAllGuests( array('event_id' => $eventDataInd['eventID']) );

            foreach($tmp_attendees as $tmp){
                $aUserId = $tmp['user_id'];
                if($aUserId != 0){
                    foreach($tmp as $aKey => $aVal){
                        if($aKey == 'user_id'){
                            if(!isset($attendees[$aUserId])){
                                $attendees[$aUserId] = array(
                                    'user_id' => $tmp['user_id'],
                                    'event_id' => $eventDataInd['eventID'],
                                    'role_id' => "3",//by default let's assume it's only a user or attendee
                                    'itinerary'=> array(),
                                    'breakout' => array(),
                                'preferences' => array(),
                                'status'=> ""
                                );
                            }
                        }
                        if($aKey == 'reference_type' && $aVal == 'event'){
                            $attendees[$aUserId]['reference_type'] = $tmp['reference_type'];
                        $attendees[$aUserId]['status'] = $tmp['status'];
                        }
                        $agenda = array(
                            'reference_id'=>$tmp['reference_id'],
                            'role_id'=>$tmp['role_id'],
                        'team'=>$tmp['team'],
                        'status'=>$tmp['status']
                        );
                        //set the attendees' agenda
                        if($aKey == 'reference_type' && ($aVal == 'itinerary' || $aVal == 'agenda')){
                            if(!isset($attendees[$aUserId]['itinerary'][$tmp['reference_id']])){
                                $attendees[$aUserId]['itinerary'][$tmp['reference_id']] = $agenda;
                            }else{//incase attendee is speaker, will replace the data to avoid redundancy
                                if($tmp['role_id']==2){
                                    $attendees[$aUserId]['itinerary'][$tmp['reference_id']] = $agenda;
                                }
                            }
                        }
                        if($aKey == 'reference_type' && ($aVal == 'breakout' || $aVal == 'activity')){
                            if(!isset($attendees[$aUserId]['breakout'][$tmp['reference_id']])){
                                $attendees[$aUserId]['breakout'][$tmp['reference_id']] = $agenda;
                            }else{//incase attendee is speaker, will replace the data to avoid redundancy
                                if($tmp['role_id']==2){
                                    $attendees[$aUserId]['breakout'][$tmp['reference_id']] = $agenda;
                                }
                            }
                        }
                    }
                    //if there's any role=2,set to speaker role for the higlight purposes in ui
                    if($tmp['role_id']=='2'){
                        $attendees[$aUserId]['role_id']= '2';
                    }
                    //get user's preferences
                    $attendee_preferences = array();
                    $tmpPreferences = $this->Attendee_Activity_Preference->getAttendeeActivityPreferences(array('userID' => $aUserId));
                    if(count($tmpPreferences)> 0){
                        foreach($tmpPreferences as $tmpPref){
                            $activityPreferenceID = $tmpPref['activityPreferenceID'];
                            if(!isset($attendee_preferences[$activityPreferenceID])){
                                 $attendee_preferences[$activityPreferenceID]=array($tmpPref['activityPreferenceOptionID']=>$tmpPref);
                             }else{
                                 array_push($attendee_preferences[$activityPreferenceID],$tmpPref);
                             }
                        }
                    }
                    $attendees[$aUserId]['preferences']= $attendee_preferences;
                }
            }
            if(count($attendees)>0){
                $newEventData[$eventDataInd['eventID']]['attendees'] = $attendees;
            }else{
                $newEventData[$eventDataInd['eventID']]['attendees'] = array();
            }
            // end attendees
            //get preferences of event
            $preferences = array('itinerary'=>array(),'breakout'=>array());
            $activityPref = $this->Activity_Preference->getActivityPreferences(array('event_id' => $eventDataInd['eventID']));
            foreach ($activityPref as $actPref){
                if($actPref['referenceType']=="agenda"){
                    if(!isset($preferences['itinerary'][$actPref['referenceID']])){
                        $preferences['itinerary'][$actPref['referenceID']] = array($actPref);
                    }else{
                        array_push($preferences['itinerary'][$actPref['referenceID']], $actPref);
                    }

                }
                if($actPref['referenceType']=="activity"){
                    if(!isset($preferences['breakout'][$actPref['referenceID']])){
                        $preferences['breakout'][$actPref['referenceID']] = array($actPref);
                    }else{
                        array_push($preferences['breakout'][$actPref['referenceID']], $actPref);
                    }
                }
            }
            $newEventData[$eventDataInd['eventID']]['preferences']=$preferences;

            //get maps associated to event

            $mapData = array();
            $mapData = $this->Map_Photo->fetch(array('event_id'=>$eventDataInd['eventID']));
            if (count($mapData)>1){
                $newMapData = array();
                foreach($mapData as $tempMapData) {
                    $newMapData[$tempMapData['mapPhotoID']] = $tempMapData;
                }
                $newEventData[$eventDataInd['eventID']]['maps'] = $newMapData;
            } else {
                $newEventData[$eventDataInd['eventID']]['maps'] = array();
            }

            //get breakout entries associated to event
            if (count($itinerayIDList)>0) {
                $breakoutEntriesData = array();

                $newBreakoutData = array();
                foreach ($itinerayIDList as $itineraryID) {
                    $breakoutEntriesData = $this->Breakout->getAllBreakouts(array('itinerary_id'=>$itineraryID));

                    if($breakoutEntriesData > 0){
                        foreach($breakoutEntriesData as $keyx => $breakoutDataInd):

                        //retrieve speakers
                        $arrSpeakers = $arrTempSpeakers = array();
                        $searchOptions = array();
                        $searchOptions['role_id'] = 2;
                        $searchOptions['reference_id'] = $breakoutDataInd['breakoutID'];
                        $searchOptions['reference_type'] = 'breakout';
                        $arrSpeakers =  $this->Guest->getAllGuests($searchOptions);

                        $breakoutDataInd['speakers'] = '';
                        if (is_array($arrSpeakers)) {
                            foreach($arrSpeakers as $speaker) {
                                array_push($arrTempSpeakers, $userData[$speaker['user_id']]['first_name'] . " " .$userData[$speaker['user_id']]['last_name']);
                            }
                            $breakoutDataInd['speakers'] = implode(",", $arrTempSpeakers);
                        }
                            $newBreakoutData[$breakoutDataInd['breakoutID']] = $breakoutDataInd;
                        endforeach;
                    }
                    $newItineraryData[$itineraryDataInd['itineraryID']]['breakout']=$newBreakoutData;
                }
                $newEventData[$eventDataInd['eventID']]['breakout'] = $newBreakoutData;

            } else {
                $newEventData[$eventDataInd['eventID']]['breakout'] = array();
            }



            //get presentation category associated to event
            $presentationCategoryData = array();
            $presentationCategoryData = $this->Presentation_Category->getPresentationCategories(array('event_id'=>$eventDataInd['eventID']));
            if (count($presentationCategoryData)>0){
                $newPresentationCategoryData = array();
                foreach($presentationCategoryData as $category) {
                    $category['presentationList'] = $this->getPresentations($category['presentationCategoryID']);
                    $newPresentationCategoryData[$category['presentationCategoryID']] = $category;
                }
                $newEventData[$eventDataInd['eventID']]['presentations'] = $newPresentationCategoryData;
            } else {
                $newEventData[$eventDataInd['eventID']]['presentations'] = array();
            }

        endforeach;
        return $newEventData;
    }

    private function getAllPresentations(){
        $presentationCategories = $this->Presentation_Category->getPresentationCategories();

        $presentationCategoryData = array();

        foreach ($presentationCategories as $category) {
            $category['presentationList'] = $this->getPresentations($category['presentationCategoryID']);
            $presentationCategoryData[$category['presentationCategoryID']] = $category;
        }

        return $presentationCategoryData;
    }

    private function getPresentations($presentation_category_id) {
            $presentations = $presentationData = array();
            $presentations = $this->Presentation->getPresentation(array('presentation_category_id'=>$presentation_category_id, 'sort_field' => 'order', 'sort_order' => 'ASC'));

        $updated_presentations = array();
        $uploadPath = $this->config->config['upload_path'] . 'presentation';


        foreach ($presentations as $presentation) {
            $temp = $presentation;

            $upload_path = str_replace('application', '', $uploadPath);

            if(array_key_exists('display_type', $temp)) {
                if ($temp['display_type'] != 'url') {
                    $document_meta = unserialize($temp['document_meta']);
                    $temp['url'] = $upload_path .  '/' . $document_meta['file_name'];
                }
            }
            $updated_presentations[] = $temp;
        }
            return $updated_presentations;
    }

    private function getAllEventAttendees(){
        $options = array();
        $guests = array();
        $event_attendees = array();

        $options['order_by'] = "user_id";
        $guests = $this->Guest->getAllGuests();

        $userID = 0;
        $eventID = 0;
        foreach($guests as $guest){
            $userID = $guest['user_id'];
            $eventID = $guest['event_id'];
            $event_attendees[$userID][$eventID][] = $guest;
        }
        return $event_attendees;
    }

    /**
     * @method allRecord
     * @return Array $events(
     *         'event_id' => array (
     *                 'eventID' => int,
     *                 'title' => string,
     *                 'description' => string,
     *                 'start_date_time' => string,
     *                 'end_date_time' => string,
     *                 'location' => string,
     *                 'status' => int,
     *                 'additional_info' => string,
     *                 'itineraries' => array(),
     *                 'breakouts' => array(),
     *                 'attendees' => array(),
     *                 'speakers' => array(),
     *                 'maps' => array()
     *             )
     *     );
     */
    private function getAllEvents(){
        $tmp_events = array();
        $events = array();
        $tmp_breakouts = array();
        $breakouts = array();

        $tmp_events = $this->Event->getAllEvents(array('status'=>1));

        foreach($tmp_events as $key=>$eventData){
            $events[$eventData['eventID']]['details'] = $eventData;
            $itineraries = array();
            $itineraries = $this->Itinerary->getAllItineraries(array($eventData['eventID']));

            $itineraries = make_new_key($itineraries, 'itineraryID');
            $events[$eventData['eventID']]['itineraries'] = $itineraries;
            /*
            foreach ($itineraries as $itinerary) {
                $itineraryID = $itinerary['itineraryID'];
                //$breakouts
            }
            //getItineraryBreakouts
            */
        }
        return $events;
    }

    /**
     * @method allRecord
     * @param string category    // id parameter of type integer
     * @param string sort_field // the field to sort
     * @param string sort_order // ASC|DESC sort order
     * @param int page // the current page in the pagination
     * @param int per_page // the limit of rows per page
     * @return json/xml data
     */
    public function allRecord_get()
    {
        $contentControlData = array();
        $allData = array();
        $userData = array();
        $eventAttendees = array();
        $tmp_companions = array();
        $companions = array();
        $tmp_options = array();
        $options = array();

        //$allData = $this->getEverything();
        $eventData = $this->Event->getAllEvents(array('status'=>1));
        $this->getAllEvents();
        $contentControlData = current($this->Content_Control->getLastUpdate());
        $userData = $this->getAllUsers();
        $eventAttendees = $this->getAllEventAttendees();

        $tmp_companions = $this->Companion->getAllCompanions();
        foreach ($tmp_companions as $companion){
            $companions[$companion['user_id']] = $companion;
        }

        $tmp_options = $this->Activity_Preference_Option->getActivityPreferenceOptions();
        foreach ($tmp_options as $opt){
            if(!isset($options[$opt['activityPreferenceID']])){
                $options[$opt['activityPreferenceID']] = array($opt['activityPreferenceOptionID']=>$opt);
            }else{
                array_push($options[$opt['activityPreferenceID']],$opt);
            }
        }

        $arrResponse = array(
            'record' => array(
                'lastUpdate' => $contentControlData['last_update'],
                'users' => $userData,
                'companion'=> $companions,
                'event_attendees'=> $eventAttendees,
                'preferences_options' => $options,
                'events' => $allData
            ),
        );

        $this->response($arrResponse);
    }

    private function getUserTeams($users){
        $new_users = array();
        foreach ($users as $user) {
            $teams = array();
            $guests = $this->Guest->getAllGuests(array('user_id'=>$user['userID'], 'role_id'=>4, 'status'=>'approved'));
            foreach ($guests as $guest) {
                $teams[$guest['reference_id']] = array(
                                    'userID' => $guest['user_id'],
                                    'team' => $guest['team'],
                                    'referenceID' => $guest['reference_id'],
                                    'referenceType' => $guest['reference_type'],
                                    'status' => $guest['status'],
                );
            }
            $user['teams'] = $teams;
            $new_users[$user['userID']] = $user;
        }
        return $new_users;
    }
}