<?php

class Mailer{
    public function sendMail($from, $to, $subject, $body, $companyName){
        $mail = mail($to, $subject, $body, "FROM: ".$companyName." <".$from.">");
        if($mail){ return true; } else { return false; }
    }
}