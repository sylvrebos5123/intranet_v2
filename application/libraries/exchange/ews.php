<?php
/// test exchange - éssai
$rootpath = APPPATH.'\\libraries';
require_once($rootpath.'\\php-ews\\ExchangeWebServices.php');
require_once($rootpath.'\\php-ews\\NTLMSoapClient.php');
require_once($rootpath.'\\php-ews\\NTLMSoapClient/Exchange.php');
require_once($rootpath.'\\php-ews\\EWS_Exception.php');
require_once($rootpath.'\\php-ews\\EWSType.php');
require_once($rootpath.'\\php-ews\\EWSType\\MessageType.php');
require_once($rootpath.'\\php-ews\\EWSType\\EmailAddressType.php');
require_once($rootpath.'\\php-ews\\EWSType\\BodyType.php');
require_once($rootpath.'\\php-ews\\EWSType\\SingleRecipientType.php');
require_once($rootpath.'\\php-ews\\EWSType\\CreateItemType.php');
require_once($rootpath.'\\php-ews\\EWSType\\NonEmptyArrayOfAllItemsType.php');
require_once($rootpath.'\\php-ews\\EWSType\\ItemType.php');
require_once($rootpath.'\\php-ews\\EWSType\\FindItemType.php');
require_once($rootpath.'\\php-ews\\EWSType\\ItemQueryTraversalType.php');
require_once($rootpath.'\\php-ews\\EWSType\\ItemResponseShapeType.php');
require_once($rootpath.'\\php-ews\\EWSType\\CalendarViewType.php');
require_once($rootpath.'\\php-ews\\EWSType\\DistinguishedFolderIdType.php');
require_once($rootpath.'\\php-ews\\EWSType\\DistinguishedFolderIdNameType.php');
require_once($rootpath.'\\php-ews\\EWSType\\DefaultShapeNamesType.php');
require_once($rootpath.'\\php-ews\\EWSType\\NonEmptyArrayOfBaseFolderIdsType.php');
require_once($rootpath.'\\php-ews\\EWSType\\NonEmptyArrayOfBaseItemIdsType.php');
require_once($rootpath.'\\php-ews\\EWSType\\ItemIdType.php');
require_once($rootpath.'\\php-ews\\EWSType\\CalendarItemType.php');
require_once($rootpath.'\\php-ews\\EWSType\\CalendarItemCreateOrDeleteOperationType.php');
require_once($rootpath.'\\php-ews\\EWSType\\AttendeeType.php');
require_once($rootpath.'\\php-ews\\EWSType\\ArrayOfStringsType.php');
require_once($rootpath.'\\php-ews\\EWSType\\DeleteItemType.php');
require_once($rootpath.'\\php-ews\\EWSType\\DisposalType.php');

function GetEwsWorkingWeekListItems($username,$password,$request_date, $working_days, $sortorder)
{
 $rootpath = APPPATH.'\\libraries';
 include($rootpath.'\\config_ews\\config_ews.php');

 $a_date = explode('-', $request_date);
 $temp_date = mktime(0, 0, 0, $a_date[1], $a_date[0], $a_date[2]);
 $nd_day = date('N',$temp_date);

 $temp_fromdate = mktime(0, 0, 0, $a_date[1], $a_date[0]-($nd_day-1), $a_date[2]);
 $ewsfromdate = date('Y-m-d',$temp_fromdate).'T00:00:00';

 $temp_todate = mktime(0, 0, 0, $a_date[1], $a_date[0]+($working_days-$nd_day), $a_date[2]);
 $ewstodate = date('Y-m-d',$temp_todate).'T23:59:59';

 $ews = new ExchangeWebServices($hostmail, $username, $password);
 $request = new EWSType_FindItemType();
 $request->Traversal = EWSType_ItemQueryTraversalType::SHALLOW;
 $request->ItemShape = new EWSType_ItemResponseShapeType();
 $request->ItemShape->BaseShape = EWSType_DefaultShapeNamesType::DEFAULT_PROPERTIES;

 $request->CalendarView = new EWSType_CalendarViewType();
 $request->CalendarView->BasePoint = 'Beginning';
 $request->CalendarView->Offset = 0;


 //$request->CalendarView->StartDate = '2012-02-27T00:00:00';
 //$request->CalendarView->EndDate = '2012-03-03T00:00:00'; 

 $request->CalendarView->StartDate = $ewsfromdate;
 $request->CalendarView->EndDate = $ewstodate;

 $request->ParentFolderIds = new EWSType_NonEmptyArrayOfBaseFolderIdsType();
 $request->ParentFolderIds->DistinguishedFolderId = new EWSType_DistinguishedFolderIdType();
 $request->ParentFolderIds->DistinguishedFolderId->Id = EWSType_DistinguishedFolderIdNameType::CALENDAR;

 $a_rdv = array();
 try
 {
  $response = $ews->FindItem($request);
 }
 catch (EWS_Exception $e)
 {
  if ($e->getCode() == 401)
   $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'WEEKCALENDARITEM','STATUS_REQUEST'=>'CONNEXION_ERROR');
  else
   $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'WEEKCALENDARITEM','STATUS_REQUEST'=>$e->getMessage());
  return $a_rdv;
 }

 $DateTimeZone = timezone_open('UTC');
 $DateTZ = timezone_open('Europe/Brussels');

 $number_cal = $response->ResponseMessages->FindItemResponseMessage->RootFolder->TotalItemsInView;

 switch ($number_cal)
 {
  case 0:
   $a_rdv = array();
   break;
  case 1:
   $a_rdv = array();
   $cal_rdv = $response->ResponseMessages->FindItemResponseMessage->RootFolder->Items->CalendarItem;
   $a_temp = explode('T', $cal_rdv->Start);
   $a_date = explode('-', $a_temp[0]);
   $temp_start_date = $a_date[2].'/'.$a_date[1].'/'.$a_date[0];
   $temp_start_heure = substr($a_temp[1],0,5);

   $a_temp = explode('T', $cal_rdv->End);
   $a_date = explode('-', $a_temp[0]);
   $temp_end_date = $a_date[2].'/'.$a_date[1].'/'.$a_date[0];
   $temp_end_heure = substr($a_temp[1],0,5);

   $dateSrc = $cal_rdv->Start;
   $local_start = date_create($dateSrc);
   //date_timezone_set($local_start, $DateTimeZone);
   date_timezone_set($local_start, $DateTZ);
  
   $dateSrc = $cal_rdv->End;
   $local_end = date_create($dateSrc);
   //date_timezone_set($local_end, $DateTimeZone);
   date_timezone_set($local_end, $DateTZ);

   $temp_start_date = $local_start->format('d/m/Y');
   $temp_start_heure = $local_start->format('H:i');

   $temp_end_date = $local_end->format('d/m/Y');
   $temp_end_heure = $local_end->format('H:i');

   $key_array = $cal_rdv->Start.'||'.$cal_rdv->End.'||'.$cal_rdv->ItemId->Id.'||'.$cal_rdv->ItemId->ChangeKey;
   $a_rdv[$key_array] = array("ID"=>$cal_rdv->ItemId->Id,"CHANGEKEY"=>$cal_rdv->ItemId->ChangeKey,"EXCHANGE_DEBUT"=>$cal_rdv->Start,"EXCHANGE_FIN"=>$cal_rdv->End,"LOCAL_DEBUT"=>$local_start->format('Y-m-d\TH:i:s\Z'),"LOCAL_FIN"=>$local_end->format('Y-m-d\TH:i:s\Z'),"START_DATE"=>$temp_start_date,"START_HEURE"=>$temp_start_heure,"END_DATE"=>$temp_end_date,"END_HEURE"=>$temp_end_heure,"SUJET"=>$cal_rdv->Subject,"OU"=>$cal_rdv->Location);
   break;
  default:
   if ($number_cal < 1)
    $a_rdv = array();
   else
   {
    $array_ech = $response->ResponseMessages->FindItemResponseMessage->RootFolder->Items->CalendarItem;
 
    for ($i=0;$i<$number_cal;$i++)
    {
     $cal_rdv = $array_ech[$i];
     //2012-02-27T08:30:00Z
     $a_temp = explode('T', $cal_rdv->Start);
     $a_date = explode('-', $a_temp[0]);
     $temp_start_date = $a_date[2].'/'.$a_date[1].'/'.$a_date[0];
     $temp_start_heure = substr($a_temp[1],0,5);

     $a_temp = explode('T', $cal_rdv->End);
     $a_date = explode('-', $a_temp[0]);
     $temp_end_date = $a_date[2].'/'.$a_date[1].'/'.$a_date[0];
     $temp_end_heure = substr($a_temp[1],0,5);

	 $dateSrc = $cal_rdv->Start;
     $local_start = date_create($dateSrc);
     //date_timezone_set($local_start, $DateTimeZone);
     date_timezone_set($local_start, $DateTZ);
  
     $dateSrc = $cal_rdv->End;
     $local_end = date_create($dateSrc);
     //date_timezone_set($local_end, $DateTimeZone);
     date_timezone_set($local_end, $DateTZ);

     $temp_start_date = $local_start->format('d/m/Y');
     $temp_start_heure = $local_start->format('H:i');

     $temp_end_date = $local_end->format('d/m/Y');
     $temp_end_heure = $local_end->format('H:i');

     $key_array = $cal_rdv->Start.'||'.$cal_rdv->End.'||'.$cal_rdv->ItemId->Id;
     $a_rdv[$key_array] = array("ID"=>$cal_rdv->ItemId->Id,"CHANGEKEY"=>$cal_rdv->ItemId->ChangeKey,"EXCHANGE_DEBUT"=>$cal_rdv->Start,"EXCHANGE_FIN"=>$cal_rdv->End,"LOCAL_DEBUT"=>$local_start->format('Y-m-d\TH:i:s\Z'),"LOCAL_FIN"=>$local_end->format('Y-m-d\TH:i:s\Z'),"START_DATE"=>$temp_start_date,"START_HEURE"=>$temp_start_heure,"END_DATE"=>$temp_end_date,"END_HEURE"=>$temp_end_heure,"SUJET"=>$cal_rdv->Subject,"OU"=>$cal_rdv->Location);
    }
   }
   break;
 }

 if ($sortorder == 'D')
  krsort($a_rdv);
 else
  ksort($a_rdv);

 return $a_rdv;
}

function GetEwsCalFromToListItems($username,$password,$fromdate, $todate,$sortorder)
{
 $rootpath = APPPATH.'\\libraries';
 include($rootpath.'\\config_ews\\config_ews.php');

 $a_date = explode('-', $fromdate);
 $ewsfromdate = $a_date[2].'-'.$a_date[1].'-'.$a_date[0].'T00:00:00';
 
 $a_date = explode('-', $todate);
 $ewstodate = $a_date[2].'-'.$a_date[1].'-'.$a_date[0].'T23:59:59';

 $ews = new ExchangeWebServices($hostmail, $username, $password);
 $request = new EWSType_FindItemType();
 $request->Traversal = EWSType_ItemQueryTraversalType::SHALLOW;
 $request->ItemShape = new EWSType_ItemResponseShapeType();
 $request->ItemShape->BaseShape = EWSType_DefaultShapeNamesType::DEFAULT_PROPERTIES;
 //$request->ItemShape->BaseShape = EWSType_DefaultShapeNamesType::ALL_PROPERTIES;

 $request->CalendarView = new EWSType_CalendarViewType();
 $request->CalendarView->BasePoint = 'Beginning';
 $request->CalendarView->Offset = 0;

 //$request->CalendarView->StartDate = '2012-02-27T00:00:00';
 //$request->CalendarView->EndDate = '2012-03-03T00:00:00'; 

 $request->CalendarView->StartDate = $ewsfromdate;
 $request->CalendarView->EndDate = $ewstodate;

 $request->ParentFolderIds = new EWSType_NonEmptyArrayOfBaseFolderIdsType();
 $request->ParentFolderIds->DistinguishedFolderId = new EWSType_DistinguishedFolderIdType();
 $request->ParentFolderIds->DistinguishedFolderId->Id = EWSType_DistinguishedFolderIdNameType::CALENDAR;

 $a_rdv = array();
 try
 {
  $response = $ews->FindItem($request);
 }
 
 catch (EWS_Exception $e)
 {
  if ($e->getCode() == 401)
   $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'LISTCALENDARITEM','STATUS_REQUEST'=>'CONNEXION_ERROR');
  else
   $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'LISTCALENDARITEM','STATUS_REQUEST'=>$e->getMessage());
  return $a_rdv;
 }

 $DateTimeZone = timezone_open('UTC');
 $DateTZ = timezone_open('Europe/Brussels');

 $number_cal = $response->ResponseMessages->FindItemResponseMessage->RootFolder->TotalItemsInView;
 switch ($number_cal)
 {
  case 0:
   $a_rdv = array();
   break;
  case 1:
   $a_rdv = array();
   $cal_rdv = $response->ResponseMessages->FindItemResponseMessage->RootFolder->Items->CalendarItem;
   $a_temp = explode('T', $cal_rdv->Start);
   $a_date = explode('-', $a_temp[0]);
   $temp_start_date = $a_date[2].'/'.$a_date[1].'/'.$a_date[0];
   $temp_start_heure = substr($a_temp[1],0,5);

   $a_temp = explode('T', $cal_rdv->End);
   $a_date = explode('-', $a_temp[0]);
   $temp_end_date = $a_date[2].'/'.$a_date[1].'/'.$a_date[0];
   $temp_end_heure = substr($a_temp[1],0,5);

   $dateSrc = $cal_rdv->Start;
   $local_start = date_create($dateSrc);
   //date_timezone_set($local_start, $DateTimeZone);
   date_timezone_set($local_start, $DateTZ);
  
   $dateSrc = $cal_rdv->End;
   $local_end = date_create($dateSrc);
   //date_timezone_set($local_end, $DateTimeZone);
   date_timezone_set($local_end, $DateTZ);

   $temp_start_date = $local_start->format('d/m/Y');
   $temp_start_heure = $local_start->format('H:i');

   $temp_end_date = $local_end->format('d/m/Y');
   $temp_end_heure = $local_end->format('H:i');

   $key_array = $cal_rdv->Start.'||'.$cal_rdv->End.'||'.$cal_rdv->ItemId->Id.'||'.$cal_rdv->ItemId->ChangeKey;
   $a_rdv[$key_array] = array("ID"=>$cal_rdv->ItemId->Id,"CHANGEKEY"=>$cal_rdv->ItemId->ChangeKey,"EXCHANGE_DEBUT"=>$cal_rdv->Start,"EXCHANGE_FIN"=>$cal_rdv->End,"LOCAL_DEBUT"=>$local_start->format('Y-m-d\TH:i:s\Z'),"LOCAL_FIN"=>$local_end->format('Y-m-d\TH:i:s\Z'),"START_DATE"=>$temp_start_date,"START_HEURE"=>$temp_start_heure,"END_DATE"=>$temp_end_date,"END_HEURE"=>$temp_end_heure,"SUJET"=>$cal_rdv->Subject,"OU"=>$cal_rdv->Location);
   break;
  default:
   if ($number_cal < 1)
    $a_rdv = array();
   else
   {
    $array_ech = $response->ResponseMessages->FindItemResponseMessage->RootFolder->Items->CalendarItem;

    for ($i=0;$i<$number_cal;$i++)
    {
     $cal_rdv = $array_ech[$i];
     //echo '<pre>'.print_r($cal_rdv, true).'</pre>';
     //2012-02-27T08:30:00Z
     $a_temp = explode('T', $cal_rdv->Start);
     $a_date = explode('-', $a_temp[0]);
     $temp_start_date = $a_date[2].'/'.$a_date[1].'/'.$a_date[0];
     $temp_start_heure = substr($a_temp[1],0,5);

     $a_temp = explode('T', $cal_rdv->End);
     $a_date = explode('-', $a_temp[0]);
     $temp_end_date = $a_date[2].'/'.$a_date[1].'/'.$a_date[0];
     $temp_end_heure = substr($a_temp[1],0,5);

     $dateSrc = $cal_rdv->Start;
     $local_start = date_create($dateSrc);
     //date_timezone_set($local_start, $DateTimeZone);
     date_timezone_set($local_start, $DateTZ);
  
     $dateSrc = $cal_rdv->End;
     $local_end = date_create($dateSrc);
     //date_timezone_set($local_end, $DateTimeZone);
     date_timezone_set($local_end, $DateTZ);

     $temp_start_date = $local_start->format('d/m/Y');
     $temp_start_heure = $local_start->format('H:i');

     $temp_end_date = $local_end->format('d/m/Y');
     $temp_end_heure = $local_end->format('H:i');

     $key_array = $cal_rdv->Start.'||'.$cal_rdv->End.'||'.$cal_rdv->ItemId->Id.'||'.$cal_rdv->ItemId->ChangeKey;
     $a_rdv[$key_array] = array("ID"=>$cal_rdv->ItemId->Id,"CHANGEKEY"=>$cal_rdv->ItemId->ChangeKey,"EXCHANGE_DEBUT"=>$cal_rdv->Start,"EXCHANGE_FIN"=>$cal_rdv->End,"LOCAL_DEBUT"=>$local_start->format('Y-m-d\TH:i:s\Z'),"LOCAL_FIN"=>$local_end->format('Y-m-d\TH:i:s\Z'),"START_DATE"=>$temp_start_date,"START_HEURE"=>$temp_start_heure,"END_DATE"=>$temp_end_date,"END_HEURE"=>$temp_end_heure,"SUJET"=>$cal_rdv->Subject,"OU"=>$cal_rdv->Location);
    }
   }
   break;
 }
 
 if ($sortorder == 'D')
  krsort($a_rdv);
 else
  ksort($a_rdv);

 return $a_rdv;
}

function GetEwsCalendarItem($username,$password,$item_id)
{
 $rootpath = APPPATH.'\\libraries';
 include($rootpath.'\\config_ews\\config_ews.php');
 $ews = new ExchangeWebServices($hostmail, $username, $password);

 $request = new EWSType_FindItemType();

 $request->ItemShape = new EWSType_ItemResponseShapeType();
 $request->ItemShape->BaseShape = EWSType_DefaultShapeNamesType::ALL_PROPERTIES;

 $request->ItemIds = new EWSType_NonEmptyArrayOfBaseItemIdsType();
 $request->ItemIds->ItemId = new EWSType_ItemIdType();
 $request->ItemIds->ItemId->Id = $item_id;
 $a_rdv = array();
 try
 {
  $response = $ews->GetItem($request);
 }
 catch (EWS_Exception $e)
 {
  if ($e->getCode() == 401)
   $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'GETCALENDARITEM','STATUS_REQUEST'=>'CONNEXION_ERROR');
  else
   $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'GETCALENDARITEM','STATUS_REQUEST'=>$e->getMessage());
  return $a_rdv;
 }

 $ResponseClass = $response->ResponseMessages->GetItemResponseMessage->ResponseClass;
 $ResponseCode = $response->ResponseMessages->GetItemResponseMessage->ResponseCode;
 if ($ResponseClass == 'Error')
 {
  $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'GETCALENDARITEM','STATUS_REQUEST'=>'ERROR');
  return $a_rdv;
 }
 
 $array_ech = $response->ResponseMessages->GetItemResponseMessage->Items->CalendarItem;

 $DateTimeZone = timezone_open('UTC');
 $DateTZ = timezone_open('Europe/Brussels');
  
 $dateSrc = $array_ech->Start;
 $local_start = date_create($dateSrc);
 //date_timezone_set($local_start, $DateTimeZone);
 date_timezone_set($local_start, $DateTZ);
  
 $dateSrc = $array_ech->End;
 $local_end = date_create($dateSrc);
 //date_timezone_set($local_end, $DateTimeZone);
 date_timezone_set($local_end, $DateTZ);
  
 $temp_start_date = $local_start->format('d/m/Y');
 $temp_start_heure = $local_start->format('H:i');

 $temp_end_date = $local_end->format('d/m/Y');
 $temp_end_heure = $local_end->format('H:i');
  
 $name_organisateur = $array_ech->Organizer->Mailbox->Name;
 $email_organisateur = $array_ech->Organizer->Mailbox->EmailAddress;
 $array_organisateur = array('NAME'=>trim($name_organisateur),'EMAIL'=>trim($email_organisateur));

 $array_RequiredAttendees = array();
 if (isset($array_ech->RequiredAttendees) == true)
 {
  $temp_attendees = $array_ech->RequiredAttendees;
  if (gettype($temp_attendees->Attendee) == 'array')
  {
   foreach($temp_attendees->Attendee as $Ovalue)
   {
    $temp_att_Name = $Ovalue->Mailbox->Name;
    $temp_att_EmailAddress = $Ovalue->Mailbox->EmailAddress;
    if (isset($Ovalue->ResponseType) == true)
     $temp_att_ResponseType = $Ovalue->ResponseType; //Accept - Unknown - Decline
    else
     $temp_att_ResponseType = 'Unknown';
    if (isset($Ovalue->LastResponseTime) == true)
     $temp_LastResponseTime = $Ovalue->LastResponseTime;
    else
     $temp_LastResponseTime = '';
    if ((trim($temp_att_Name) != '') && ($temp_att_Name != null))
     $array_RequiredAttendees[] = array('NAME'=>trim($temp_att_Name),'EMAIL'=>trim($temp_att_EmailAddress),'REPONSE'=>strtoupper(trim($temp_att_ResponseType)),'DERNIEREREPONSE'=>trim($temp_LastResponseTime));
   }
  }
  else
  {
   $Ovalue = $temp_attendees->Attendee;

   $temp_att_Name = $Ovalue->Mailbox->Name;
   $temp_att_EmailAddress = $Ovalue->Mailbox->EmailAddress;
   if (isset($Ovalue->ResponseType) == true)
    $temp_att_ResponseType = $Ovalue->ResponseType; //Accept - Unknown - Decline
   else
    $temp_att_ResponseType = 'Unknown';
   if (isset($Ovalue->LastResponseTime) == true)
    $temp_LastResponseTime = $Ovalue->LastResponseTime;
   else
    $temp_LastResponseTime = '';
   if ((trim($temp_att_Name) != '') && ($temp_att_Name != null))
    $array_RequiredAttendees[] = array('NAME'=>trim($temp_att_Name),'EMAIL'=>trim($temp_att_EmailAddress),'REPONSE'=>strtoupper(trim($temp_att_ResponseType)),'DERNIEREREPONSE'=>trim($temp_LastResponseTime));
  }
 }

 $array_OptionalAttendees = array();
 if (isset($array_ech->OptionalAttendees) == true)
 {
  $temp_attendees = $array_ech->OptionalAttendees;
  //echo gettype($temp_attendees->Attendee).'<br />';
  if (gettype($temp_attendees->Attendee) == 'array')
  {
   foreach($temp_attendees->Attendee as $Ovalue)
   {
    $temp_att_Name = $Ovalue->Mailbox->Name;
    $temp_att_EmailAddress = $Ovalue->Mailbox->EmailAddress;
    if (isset($Ovalue->ResponseType) == true)
     $temp_att_ResponseType = $Ovalue->ResponseType; //Accept - Unknown - Decline
    else
     $temp_att_ResponseType = 'Unknown';
    if (isset($Ovalue->LastResponseTime) == true)
     $temp_LastResponseTime = $Ovalue->LastResponseTime;
    else
     $temp_LastResponseTime = '';
    if ((trim($temp_att_Name) != '') && ($temp_att_Name != null))
     $array_OptionalAttendees[] = array('NAME'=>trim($temp_att_Name),'EMAIL'=>trim($temp_att_EmailAddress),'REPONSE'=>strtoupper(trim($temp_att_ResponseType)),'DERNIEREREPONSE'=>trim($temp_LastResponseTime));
   }
  }
  else
  {
   $Ovalue = $temp_attendees->Attendee;

   $temp_att_Name = $Ovalue->Mailbox->Name;
   $temp_att_EmailAddress = $Ovalue->Mailbox->EmailAddress;
   if (isset($Ovalue->ResponseType) == true)
    $temp_att_ResponseType = $Ovalue->ResponseType; //Accept - Unknown - Decline
   else
    $temp_att_ResponseType = 'Unknown';
   if (isset($Ovalue->LastResponseTime) == true)
    $temp_LastResponseTime = $Ovalue->LastResponseTime;
   else
    $temp_LastResponseTime = '';
   if ((trim($temp_att_Name) != '') && ($temp_att_Name != null))
    $array_OptionalAttendees[] = array('NAME'=>trim($temp_att_Name),'EMAIL'=>trim($temp_att_EmailAddress),'REPONSE'=>strtoupper(trim($temp_att_ResponseType)),'DERNIEREREPONSE'=>trim($temp_LastResponseTime));
  }
 } 

 $temp_body_value = $array_ech->Body->_;
 $body_type = $array_ech->Body->BodyType; 
 if (trim($temp_body_value) != '')
 {
  if (trim($body_type) == 'HTML')
  {
   $temp_html_1 = explode('<body>', trim($temp_body_value));
   $temp_html = explode('</body>', trim($temp_html_1[1]));
   $html = trim($temp_html[0]);
  }
  else
   $html = $temp_body_value;
 }
 else
  $html = '';
 
 $key_array = $array_ech->ItemId->Id.'||'.$array_ech->ItemId->ChangeKey;
 $a_rdv[$key_array] = array("REQUEST_RESULT"=>true,'EWS_ACTION'=>'GETCALENDARITEM',"ID"=>$array_ech->ItemId->Id,"CHANGEKEY"=>$array_ech->ItemId->ChangeKey,"EXCHANGE_DEBUT"=>$array_ech->Start,"EXCHANGE_FIN"=>$array_ech->End,"LOCAL_DEBUT"=>$local_start->format('Y-m-d\TH:i:s\Z'),"LOCAL_FIN"=>$local_end->format('Y-m-d\TH:i:s\Z'),"START_DATE"=>$temp_start_date,"START_HEURE"=>$temp_start_heure,"END_DATE"=>$temp_end_date,"END_HEURE"=>$temp_end_heure,"SUJET"=>$array_ech->Subject,"OU"=>$array_ech->Location,'ORGANISATEUR'=>$array_organisateur,'REQ_INVITES'=>$array_RequiredAttendees,'OPT_INVITES'=>$array_OptionalAttendees,'BODY'=>trim($html));
 return $a_rdv;
}

function CreateEwsCalendarItem($username,$password,$array_item)
{
 if (count($array_item) < 1)
 {
  $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'CREATECALENDAR','STATUS_REQUEST'=>'EMPTY_CALENDAR_ITEM');
  return $a_rdv;
 } 

 $rootpath = APPPATH.'\\libraries';
 include($rootpath.'\\config_ews\\config_ews.php');

 $ews = new ExchangeWebServices($hostmail, $username, $password);
 
 $request = new EWSType_CreateItemType();

 $request->Items = new EWSType_NonEmptyArrayOfAllItemsType();
 $request->Items->CalendarItem = new EWSType_CalendarItemType();
 
 if (isset($array_item['SUJET']) == true)
 {
  if ((trim($array_item['SUJET']) != '') && ($array_item['SUJET'] != null))
   $request->Items->CalendarItem->Subject = trim($array_item['SUJET']);
  else
   $request->Items->CalendarItem->Subject = '';
 }
 else
  $request->Items->CalendarItem->Subject = '';
 
 
 if (isset($array_item['OU']) == true)
 {
  if ((trim($array_item['OU']) != '') && ($array_item['OU'] != null))
   $request->Items->CalendarItem->Location = trim($array_item['OU']);
  else
   $request->Items->CalendarItem->Location = '';
 }
 else
  $request->Items->CalendarItem->Location = '';
 
 $DateTimeZone = timezone_open('UTC');
 $DateTZ = timezone_open('Europe/Brussels');
  
 //$dateSrc = $cal_rdv->Start;
 //$local_start = date_create($dateSrc);
 //date_timezone_set($local_start, $DateTimeZone);
 //date_timezone_set($local_start, $DateTZ);
  
 $temp_start_date = $array_item['START_DATE'];
 $a_date = explode('-', $temp_start_date);
 $temp_start_date = $a_date[2].'-'.$a_date[1].'-'.$a_date[0];

 //$request->Items->CalendarItem->Start = $temp_start_date.'T'.$array_item['START_HEURE'].'Z';

 $dateSrc = $temp_start_date.' '.$array_item['START_HEURE'];
 $local_start = date_create($dateSrc);
 //date_timezone_set($local_start, $DateTZ);
 //echo $local_start->format('Y-m-d\TH:i:s\Z').'<br />';
 date_timezone_set($local_start, $DateTimeZone);
 //echo $local_start->format('Y-m-d\TH:i:s\Z').'<br />';
 
 //$request->Items->CalendarItem->Start = $temp_start_date.'T'.$array_item['START_HEURE'].'Z';
 
 $request->Items->CalendarItem->Start = $local_start->format('Y-m-d\TH:i:s\Z');

 $temp_start_date = $array_item['END_DATE'];
 $a_date = explode('-', $temp_start_date);
 $temp_start_date = $a_date[2].'-'.$a_date[1].'-'.$a_date[0];
 
 //$request->Items->CalendarItem->End = $temp_start_date.'T'.$array_item['END_HEURE'].'Z';

 $dateSrc = $temp_start_date.' '.$array_item['END_HEURE'];
 $local_start = date_create($dateSrc);
 date_timezone_set($local_start, $DateTimeZone);
 //date_timezone_set($local_start, $DateTZ);

 $request->Items->CalendarItem->End = $local_start->format('Y-m-d\TH:i:s\Z');
 
 if (isset($array_item['ALLDAY']) == false)
  $request->Items->CalendarItem->IsAllDayEvent = false; // false - true
 else
 {
  if ($array_item['ALLDAY'] != true)
   $request->Items->CalendarItem->IsAllDayEvent = false; // false - true
  else
   $request->Items->CalendarItem->IsAllDayEvent = true; // false - true
 }

 if (isset($array_item['BUSYSTATUS']) == false)
  $request->Items->CalendarItem->LegacyFreeBusyStatus = 'Free'; // Busy - Free
 else
 {
  if (($array_item['BUSYSTATUS'] != 'Free') && ($array_item['BUSYSTATUS'] != 'Busy'))
   $request->Items->CalendarItem->LegacyFreeBusyStatus = 'Free'; // Busy - Free
  else
   $request->Items->CalendarItem->LegacyFreeBusyStatus = $array_item['BUSYSTATUS']; // Busy - Free
 }
 
 if (isset($array_item['CATEGORY']) == true)
 {
  $request->Items->CalendarItem->Categories = new EWSType_ArrayOfStringsType();
  $request->Items->CalendarItem->Categories->String = $array_item['CATEGORY'];
  //$request->Items->CalendarItem->Categories->String = array('Catégorie Rouge','Urgent');
 }

 if (isset($array_item['BODY']) == true)
 {
  if ((trim($array_item['BODY']) != '') && ($array_item['BODY'] != null))
  {
   if (isset($array_item['BODYTYPE']) != true)
    $request->Items->CalendarItem->Body->BodyType = 'Text'; // Text - HTML
   else
   {
    if ($array_item['BODYTYPE'] != 'HTML')
     $request->Items->CalendarItem->Body->BodyType = 'Text'; // Text - HTML
    else
     $request->Items->CalendarItem->Body->BodyType = 'HTML'; // Text - HTML
   }
   $request->Items->CalendarItem->Body->_ = trim($array_item['BODY']);
  }
  else
  {
   $request->Items->CalendarItem->Body->BodyType = 'Text';
   $request->Items->CalendarItem->Body->_ = '';
  }
 }
 else
 {
  $request->Items->CalendarItem->Body->BodyType = 'Text';
  $request->Items->CalendarItem->Body->_ = '';
 }

 if (isset($array_item['REQ_INVITE']) == true)
 {
  if (count($array_item['REQ_INVITE']) > 0)
  {
   // Setup the RequiredAttendees array
   $request->Items->CalendarItem->RequiredAttendees = array();

   $array_attendees = $array_item['REQ_INVITE'];
   foreach($array_attendees as $i => $array_temp)
   {
    $request->Items->CalendarItem->RequiredAttendees[$i] = new EWSType_AttendeeType();
    $request->Items->CalendarItem->RequiredAttendees[$i]->Mailbox = new EWSType_EmailAddressType();
    $request->Items->CalendarItem->RequiredAttendees[$i]->Mailbox->Name = $array_temp['NAME'];
    $request->Items->CalendarItem->RequiredAttendees[$i]->Mailbox->EmailAddress = $array_temp['EMAIL'];
    $request->Items->CalendarItem->RequiredAttendees[$i]->Mailbox->RoutingType = "SMTP";
   }   
  }
 }
 
 if (isset($array_item['OPT_INVITE']) == true)
 {
  if (count($array_item['OPT_INVITE']) > 0)
  {
   // Setup the OptionalAttendees array
   $request->Items->CalendarItem->OptionalAttendees = array();
   $array_attendees = $array_item['OPT_INVITE'];
   foreach($array_attendees as $i => $array_temp)
   {
    $request->Items->CalendarItem->OptionalAttendees[$i] = new EWSType_AttendeeType();
    $request->Items->CalendarItem->OptionalAttendees[$i]->Mailbox = new EWSType_EmailAddressType();
    $request->Items->CalendarItem->OptionalAttendees[$i]->Mailbox->Name = $array_temp['NAME'];
    $request->Items->CalendarItem->OptionalAttendees[$i]->Mailbox->EmailAddress = $array_temp['EMAIL'];
    $request->Items->CalendarItem->OptionalAttendees[$i]->Mailbox->RoutingType = "SMTP";
   }   
  }
 }

 //SEND_TO_NONE
 //SEND_ONLY_TO_ALL
 //SEND_TO_ALL_AND_SAVE_COPY

 if (isset($array_item['SENDINVIT']) == true)
 {
  switch(trim($array_item['SENDINVIT']))
  {
   case 'SEND_TO_NONE':
    $request->SendMeetingInvitations = EWSType_CalendarItemCreateOrDeleteOperationType::SEND_TO_NONE;
    break;
   case 'SEND_ONLY_TO_ALL':
    $request->SendMeetingInvitations = EWSType_CalendarItemCreateOrDeleteOperationType::SEND_ONLY_TO_ALL;
    break;
   case 'SEND_TO_ALL_AND_SAVE_COPY':
    $request->SendMeetingInvitations = EWSType_CalendarItemCreateOrDeleteOperationType::SEND_TO_ALL_AND_SAVE_COPY;
    break;
   default:
    $request->SendMeetingInvitations = EWSType_CalendarItemCreateOrDeleteOperationType::SEND_TO_NONE;
    break;
  }
 }
 else
  $request->SendMeetingInvitations = EWSType_CalendarItemCreateOrDeleteOperationType::SEND_TO_NONE;
 
 $a_rdv = array();
 try
 {
  $response = $ews->CreateItem($request);
 }
 catch (EWS_Exception $e)
 {
  if ($e->getCode() == 401)
   $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'CREATECALENDAR','STATUS_REQUEST'=>'CONNEXION_ERROR');
  else
   $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'CREATECALENDAR','STATUS_REQUEST'=>$e->getMessage());
  return $a_rdv;
 }

 $ResponseClass = $response->ResponseMessages->CreateItemResponseMessage->ResponseClass;
 $ResponseCode = $response->ResponseMessages->CreateItemResponseMessage->ResponseCode;

 if ($ResponseClass == 'Error')
 {
  $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'CREATECALENDAR','STATUS_REQUEST'=>'ERROR');
  return $a_rdv;
 }
 //echo '<pre>'.print_r($request, true).'</pre>';
 
 $array_ech = $response->ResponseMessages->CreateItemResponseMessage->Items->CalendarItem;
 $key_array = $array_ech->ItemId->Id.'||'.$array_ech->ItemId->ChangeKey;
 $a_rdv[$key_array] = array("REQUEST_RESULT"=>true,'EWS_ACTION'=>'CREATECALENDAR',"ID"=>$array_ech->ItemId->Id,"CHANGEKEY"=>$array_ech->ItemId->ChangeKey);
 return $a_rdv;
}

function DeleteEwsCalendarItem($username,$password,$array_item)
{
 if (count($array_item) < 1)
 {
  $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'DELETECALENDAR','STATUS_REQUEST'=>'EMPTY_CALENDAR_ITEM');
  return $a_rdv;
 }

 $item_id = $array_item['ID'];
 $change_key = $array_item['CHANGEKEY'];
 //echo $item_id.'<br />';
 //echo $change_key.'<br />';
 
 if (((trim($item_id) == '') || ($item_id == null)) || ((trim($change_key) == '') || ($change_key == null)))
 {
  $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'DELETECALENDAR','STATUS_REQUEST'=>'CALENDAR_ITEM_ID_EMPTY');
  return $a_rdv;
 }
 
 $rootpath = APPPATH.'\\libraries';
 include($rootpath.'\\config_ews\\config_ews.php');
 $ews = new ExchangeWebServices($hostmail, $username, $password);

 $request = new EWSType_DeleteItemType();

 $request->ItemIds->ItemId->Id = $item_id;
 $request->ItemIds->ItemId->ChangeKey = $change_key;

 // HARD_DELETE / MOVE_TO_DELETED_ITEMS / SOFT_DELETE
 $request->DeleteType = EWSType_DisposalType::HARD_DELETE;

 //SEND_TO_NONE
 //SEND_ONLY_TO_ALL
 //SEND_TO_ALL_AND_SAVE_COPY
 $request->SendMeetingCancellations = EWSType_CalendarItemCreateOrDeleteOperationType::SEND_ONLY_TO_ALL;

 $a_rdv = array();
 try
 {
  $response = $ews->DeleteItem($request);
 }
 catch (EWS_Exception $e)
 {
  if ($e->getCode() == 401)
   $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'DELETECALENDAR','STATUS_REQUEST'=>'CONNEXION_ERROR');
  else
   $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'DELETECALENDAR','STATUS_REQUEST'=>$e->getMessage());
  return $a_rdv;
 }

 $ResponseClass = $response->ResponseMessages->DeleteItemResponseMessage->ResponseClass;
 $ResponseCode = $response->ResponseMessages->DeleteItemResponseMessage->ResponseCode;

 $key_array = $item_id.'||'.$change_key;

 if ($ResponseClass == 'Error')
  $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'DELETECALENDAR', 'STATUS_REQUEST'=>'ERROR');
 else
  $a_rdv[$key_array] = array("REQUEST_RESULT"=>true,'EWS_ACTION'=>'DELETECALENDAR','STATUS_REQUEST'=>'ITEMDELETED');

 return $a_rdv;
}

function UpdateEwsCalendarItem($username,$password,$array_item)
{
 if (count($array_item) < 1)
 {
  $a_rdv['FAILT'] = array("REQUEST_RESULT"=>false,'EWS_ACTION'=>'UPDATECALENDAR','STATUS_REQUEST'=>'EMPTY_CALENDAR_ITEM');
  return $a_rdv;
 }
 if (isset($array_item['ID']) == true)
  $item_id = $array_item['ID'];
 else
  $item_id = '';

 if (isset($array_item['CHANGEKEY']) == true)
  $change_key = $array_item['CHANGEKEY'];
 else
  $change_key = '';

 //print $item_id.'<br />';
 //print $change_key.'<br />';
  
 if (((trim($item_id) != '') && ($item_id != null)) && ((trim($change_key) != '') && ($change_key != null)))
 {
  //print $item_id.'<br />';
  //print $change_key.'<br />';
  $a_rdv = DeleteEwsCalendarItem($username,$password,$array_item);
  if (isset($a_rdv['FAILT']) == true)
   return $a_rdv['FAILT'];
  //echo '<pre>'.print_r($a_rdv, true).'</pre>';
 }

 unset($array_item['ITEM_ID']);
 unset($array_item['CHANGE_KEY']);
 $a_rdv = CreateEwsCalendarItem($username,$password,$array_item);
 //echo '<pre>'.print_r($a_rdv, true).'</pre>';
 return $a_rdv;
}
?>