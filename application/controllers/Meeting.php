<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meeting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        redirect('https://neo.winteq-astra.com');
    }
    public function webinar()
    {
        redirect('https://teams.microsoft.com/dl/launcher/launcher.html?type=meetup-join&deeplinkId=650a2e5a-d479-4765-8ff0-495b035b5395&directDl=true&msLaunch=true&enableMobilePage=true&url=%2F_%23%2Fl%2Fmeetup-join%2F19%253ameeting_ZmZmM2JiNGUtZmE0NS00OWFlLTk1MzQtZGM2M2M2MWRhNmE1%2540thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522f5332409-fcd5-4d5d-aaf7-b5189010d0d0%2522%252c%2522Oid%2522%253a%25223509aa3d-d95b-4588-824e-a17f86b4063e%2522%257d%26anon%3Dtrue&suppressPrompt=true');
    }
}
