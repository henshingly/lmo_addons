<?php
/**#@+
* We need the child class
*/
include_once 'ical/class.iCal.inc.php';
/**#@-*/


class lmo_iCal extends iCal {

    function quotedPrintableEncode($quotprint = '') { // overwrite quotedPrintableEncode for utf-8 Coding
        return (string) utf8_encode ( $quotprint );
    } // end function

    /**
    * Sends the right header information and outputs the generated content to
    * the browser
    *
    * @desc Sends the right header information
    * @param string $format  ics | xcs | rdf (only Events)
    * @return void
    * @uses getOutput()
    * @since 1.011 - 2002-12-22
    */
    function outputFile($format = 'ics') {
        if ($format == 'ics') {
            header('Content-Type: text/Calendar');
            header('Content-Disposition: attachment; filename=iCalendar_dates_' . date('Y-m-d_H-m-s') . '.ics');
            echo $this->getOutput('ics');
        } elseif ($format == 'xcs') {
            header('Content-Type: text/Calendar');
            header('Content-Disposition: attachment; filename=iCalendar_dates_' . date('Y-m-d_H-m-s') . '.xcs');
            echo $this->getOutput('xcs');
        } elseif ($format == 'rdf') {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment; filename=iCalendar_dates_' . date('Y-m-d_H-m-s') . '.rdf');
            echo $this->getOutput('rdf');
        } // end if
    } // end function


    /**
    * Writes the string into the file and saves it to the download directory
    *
    * @desc Writes the string into the file and saves it to the download directory
    * @return void
    * @see getOutput()
    * @uses checkDownloadDir()
    * @uses generateOutput()
    * @uses deleteOldFiles()
    */
    function writeFile() {
        if ($this->checkDownloadDir() == FALSE) {
            die('error creating download directory');
        } // end if
        if (!isset($this->output)) {
            $this->generateOutput();
        } // end if
        $handle = fopen($this->download_dir . '/' . $this->events_filename, 'w');
        fputs($handle, $this->output );
        fclose($handle);
//        $this->deleteOldFiles(300);
        if (isset($handle)) {
            unset($handle);
        }
    } // end function

    function generateOutput($format = 'ics') {

        if ( !function_exists('isEmpty') ) {
            function &isEmpty(&$variable) {
                return (boolean) ((strlen(trim($variable)) > 0) ? FALSE : TRUE);
            }
        }

        $this->output_format = (string) $format;
        if ($this->output_format == 'ics') {
            $this->output  = (string) "BEGIN:VCALENDAR\r\n";
            $this->output .= (string) "PRODID:" . $this->prodid . "\r\n";
            $this->output .= (string) "VERSION:2.0\r\n";
            $this->output .= (string) "METHOD:" . $this->getMethod() . "\r\n";
            $eventkeys = (array) array_keys($this->icalevents);
            foreach ($eventkeys as $id) {
                $this->output .= (string) "BEGIN:VEVENT\r\n";
                $event =& $this->icalevents[$id];
                $this->output .= (string) $this->generateAttendeesOutput($event->getAttendees(), $format);
                if (!isEmpty($event->getOrganizerMail())) {
                    $name = '';
                    if (!isEmpty($event->getOrganizerName())) {
                        $name = (string) ";CN=" . $event->getOrganizerName();
                    } // end if
                    $this->output .= (string) "ORGANIZER" . $name . ":MAILTO:" . $event->getOrganizerMail() . "\r\n";
                } // end if
                $this->output .= (string) "DTSTART:" . $event->getStartDate() . "\r\n";
                if (strlen(trim($event->getEndDate())) > 0) {
                    $this->output .= (string) "DTEND:" . $event->getEndDate() . "\r\n";
                }

                if ($event->getFrequency() > 0) {
                    $this->output .= (string) "RRULE:FREQ=" . $this->getFrequencyName($event->getFrequency());
                    if (is_string($event->getRecEnd())) {
                        $this->output .= (string) ";UNTIL=" . $event->getRecEnd();
                    } elseif (is_int($event->getRecEnd())) {
                        $this->output .= (string) ";COUNT=" . $event->getRecEnd();
                    } // end if
                    $this->output .= (string) ";INTERVAL=" . $event->getInterval() . ";BYDAY=" . $event->getDays() . ";WKST=" . $event->getWeekStart() . "\r\n";
                } // end if
                if (!isEmpty($event->getExeptDates())) {
                    $this->output .= (string) "EXDATE:" . $event->getExeptDates() . "\r\n";
                } // end if
                if (!isEmpty($event->getLocation())) {
                    $this->output .= (string) "LOCATION" . $event->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($event->getLocation()) . "\r\n";
                } // end if
                $this->output .= (string) "TRANSP:" . $event->getTransp() . "\r\n";
                $this->output .= (string) "SEQUENCE:" . $event->getSequence() . "\r\n";
                $this->output .= (string) "UID:" . $event->getUID() . "\r\n";
                $this->output .= (string) "DTSTAMP:" . $this->ical_timestamp . "\r\n";
                if (!isEmpty($event->getCategories())) {
                    $this->output .= (string) "CATEGORIES" . $event->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($event->getCategories()) . "\r\n";
                } // end if
                if (!isEmpty($event->getDescription())) {
                    $this->output .= (string) "DESCRIPTION" . $event->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . str_replace('\n', '=0D=0A=',str_replace('\r', '=0D=0A=', $this->quotedPrintableEncode($event->getDescription()))) . "\r\n";
                } // end if
                $this->output .= (string) "SUMMARY" . $event->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($event->getSummary()) . "\r\n";
                $this->output .= (string) "PRIORITY:" . $event->getPriority() . "\r\n";
                $this->output .= (string) "CLASS:" . $this->getClassName($event->getClass()) . "\r\n";
                if (!isEmpty($event->getURL())) {
                    $this->output .= (string) "URL:" . $event->getURL() . "\r\n";
                } // end if
                if (!isEmpty($event->getStatus())) {
                    $this->output .= (string) "STATUS:" . $this->getStatusName($event->getStatus()) . "\r\n";
                } // end if
                $this->output .= (string) $this->generateAlarmOutput($event->getAlarm(), $format);
                $this->output .= (string) "END:VEVENT\r\n";
            } // end foreach
            $todokeys = (array) array_keys($this->icaltodos);
            foreach ($todokeys as $id) {
                $this->output .= (string) "BEGIN:VTODO\r\n";
                $todo =& $this->icaltodos[$id];
                $this->output .= (string) $this->generateAttendeesOutput($todo->getAttendees(), $format);
                if (!isEmpty($todo->getOrganizerMail())) {
                    $name = '';
                    if (!isEmpty($todo->getOrganizerName())) {
                        $name = (string) ";CN=" . $todo->getOrganizerName();
                    } // end if
                    $this->output .= (string) "ORGANIZER" . $name . ":MAILTO:" . $todo->getOrganizerMail() . "\r\n";
                } // end if
                $this->output .= (string) "SEQUENCE:" . $todo->getSequence() . "\r\n";
                $this->output .= (string) "UID:" . $todo->getUID() . "\r\n";
                $this->output .= (string) "DTSTAMP:" . $this->ical_timestamp . "\r\n";
                if (!isEmpty($todo->getCategories())) {
                    $this->output .= (string) "CATEGORIES" . $todo->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($todo->getCategories()) . "\r\n";
                } // end if
                if (!isEmpty($todo->getDescription())) {
                    $this->output .= (string) "DESCRIPTION" . $todo->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . str_replace('\n', '=0D=0A=',str_replace('\r', '=0D=0A=', $this->quotedPrintableEncode($todo->getDescription()))) . "\r\n";
                } // end if
                $this->output .= (string) "SUMMARY" . $todo->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($todo->getSummary()) . "\r\n";
                $this->output .= (string) "PRIORITY:" . $todo->getPriority() . "\r\n";
                $this->output .= (string) "CLASS:" . $this->getClassName($todo->getClass()) . "\r\n";
                if (!isEmpty($todo->getLocation())) {
                    $this->output .= (string) "LOCATION" . $todo->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($todo->getLocation()) . "\r\n";
                } // end if
                if (!isEmpty($todo->getURL())) {
                    $this->output .= (string) "URL:" . $todo->getURL() . "\r\n";
                } // end if
                if (!isEmpty($todo->getStatus())) {
                    $this->output .= (string) "STATUS:" . $this->getStatusName($todo->getStatus()) . "\r\n";
                } // end if
                if (!isEmpty($todo->getPercent()) && $todo->getPercent() > 0) {
                    $this->output .= (string) "PERCENT-COMPLETE:" . $todo->getPercent() . "\r\n";
                } // end if
                if (!isEmpty($todo->getDuration()) && $todo->getDuration() > 0) {
                    $this->output .= (string) "DURATION:PT" . $todo->getDuration() . "M\r\n";
                } // end if
                if (!isEmpty($todo->getLastMod())) {
                    $this->output .= (string) "LAST-MODIFIED:" . $todo->getLastMod() . "\r\n";
                } // end if
                if (!isEmpty($todo->getStartDate())) {
                    $this->output .= (string) "DTSTART:" . $todo->getStartDate() . "\r\n";
                } // end if
                if (!isEmpty($todo->getCompleted())) {
                    $this->output .= (string) "COMPLETED:" . $todo->getCompleted() . "\r\n";
                } // end if
                if ($todo->getFrequency() != 'ONCE') {
                    $this->output .= (string) "RRULE:FREQ=" . $todo->getFrequency();
                    if (is_string($todo->getRecEnd())) {
                        $this->output .= (string) ";UNTIL=" . $todo->getRecEnd();
                    } elseif (is_int($todo->getRecEnd())) {
                        $this->output .= (string) ";COUNT=" . $todo->getRecEnd();
                    } // end if
                    $this->output .= (string) ";INTERVAL=" . $todo->getInterval() . ";BYDAY=" . $todo->getDays() . ";WKST=" . $todo->getWeekStart() . "\r\n";
                } // end if
                if (!isEmpty($todo->getExeptDates())) {
                    $this->output .= (string) "EXDATE:" . $todo->getExeptDates() . "\r\n";
                } // end if
                $this->output .= (string) $this->generateAlarmOutput($todo->getAlarm(), $format);
                $this->output .= (string) "END:VTODO\r\n";
            } // end foreach
            $journalkeys = (array) array_keys($this->icaljournals);
            foreach ($journalkeys as $id) {
                $this->output .= (string) "BEGIN:VJOURNAL\r\n";
                $journal =& $this->icaljournals[$id];
                $this->output .= (string) $this->generateAttendeesOutput($journal->getAttendees(), $format);
                if (!isEmpty($journal->getOrganizerMail())) {
                    $name = '';
                    if (!isEmpty($journal->getOrganizerName())) {
                        $name = (string) ";CN=" . $journal->getOrganizerName();
                    } // end if
                    $this->output .= (string) "ORGANIZER" . $name . ":MAILTO:" . $journal->getOrganizerMail() . "\r\n";
                } // end if
                $this->output .= (string) "SEQUENCE:" . $journal->getSequence() . "\r\n";
                $this->output .= (string) "UID:" . $journal->getUID() . "\r\n";
                $this->output .= (string) "DTSTAMP:" . $this->ical_timestamp . "\r\n";
                if (!isEmpty($journal->getCategories())) {
                    $this->output .= (string) "CATEGORIES" . $journal->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($journal->getCategories()) . "\r\n";
                } // end if
                if (!isEmpty($journal->getDescription())) {
                    $this->output .= (string) "DESCRIPTION" . $journal->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . str_replace('\n', '=0D=0A=',str_replace('\r', '=0D=0A=', $this->quotedPrintableEncode($journal->getDescription()))) . "\r\n";
                } // end if
                $this->output .= (string) "SUMMARY" . $journal->getLanguage() . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($journal->getSummary()) . "\r\n";
                $this->output .= (string) "CLASS:" . $this->getClassName($journal->getClass()) . "\r\n";
                if (!isEmpty($journal->getURL())) {
                    $this->output .= (string) "URL:" . $journal->getURL() . "\r\n";
                } // end if
                if (!isEmpty($journal->getStatus())) {
                    $this->output .= (string) "STATUS:" . $this->getStatusName($journal->getStatus()) . "\r\n";
                } // end if
                if (!isEmpty($journal->getLastMod())) {
                    $this->output .= (string) "LAST-MODIFIED:" . $journal->getLastMod() . "\r\n";
                } // end if
                if (!isEmpty($journal->getStartDate())) {
                    $this->output .= (string) "DTSTART:" . $journal->getStartDate() . "\r\n";
                } // end if
                if (!isEmpty($journal->getCreated())) {
                    $this->output .= (string) "CREATED:" . $journal->getCreated() . "\r\n";
                } // end if
                if ($journal->getFrequency() > 0) {
                    $this->output .= (string) "RRULE:FREQ=" . $this->getFrequencyName($journal->getFrequency());
                    if (is_string($journal->getRecEnd())) {
                        $this->output .= (string) ";UNTIL=" . $journal->getRecEnd();
                    } elseif (is_int($journal->getRecEnd())) {
                        $this->output .= (string) ";COUNT=" . $journal->getRecEnd();
                    } // end if
                    $this->output .= (string) ";INTERVAL=" . $journal->getInterval() . ";BYDAY=" . $journal->getDays() . ";WKST=" . $journal->getWeekStart() . "\r\n";
                } // end if
                if (!isEmpty($journal->getExeptDates())) {
                    $this->output .= (string) "EXDATE:" . $journal->getExeptDates() . "\r\n";
                } // end if
                $this->output .= (string) "END:VJOURNAL\r\n";
            } // end foreach
            $fbkeys = (array) array_keys($this->icalfbs);
            foreach ($fbkeys as $id) {
                $this->output .= (string) "BEGIN:VFREEBUSY\r\n";
                $fb =& $this->icalfbs[$id];
                $this->output .= (string) $this->generateAttendeesOutput($fb->getAttendees(), $format);
                if (!isEmpty($fb->getOrganizerMail())) {
                    $name = '';
                    if (!isEmpty($fb->getOrganizerName())) {
                        $name = (string) ";CN=" . $fb->getOrganizerName();
                    } // end if
                    $this->output .= (string) "ORGANIZER" . $name . ":MAILTO:" . $fb->getOrganizerMail() . "\r\n";
                } // end if
                $this->output .= (string) "UID:" . $fb->getUID() . "\r\n";
                $this->output .= (string) "DTSTAMP:" . $this->ical_timestamp . "\r\n";
                if (!isEmpty($fb->getURL())) {
                    $this->output .= (string) "URL:" . $fb->getURL() . "\r\n";
                } // end if
                if (!isEmpty($fb->getDuration()) && $fb->getDuration() > 0) {
                    $this->output .= (string) "DURATION:PT" . $fb->getDuration() . "M\r\n";
                } // end if
                if (!isEmpty($fb->getStartDate())) {
                    $this->output .= (string) "DTSTART:" . $fb->getStartDate() . "\r\n";
                } // end if
                if (!isEmpty($fb->getEndDate())) {
                    $this->output .= (string) "DTEND:" . $fb->getEndDate() . "\r\n";
                } // end if
                if (count($fb->getFBTimes()) > 0) {
                    foreach ($fb->getFBTimes() as $timestamp => $data) {
                        $values = (array) explode(',',$data);
                        $this->output .= (string) "FREEBUSY;FBTYPE=" . $values[1] . ":" . $timestamp . "/" . $values[0] . "\r\n";
                    } // end foreach
                    unset($values);
                } // end if
                $this->output .= (string) "END:VFREEBUSY\r\n";
            } // end foreach
            $this->output .= (string) "END:VCALENDAR\r\n";
        } // end if ics
        elseif ($this->output_format == 'xcs') {
            $this->output  = (string) '<?xml version="1.0" encoding="UTF-8"?>';
            //$this->output  = (string) '<!DOCTYPE iCalendar PUBLIC "-//IETF//DTD iCalendar//EN" "http://www.ietf.org/internet-drafts/draft-dawson-ical-xml-dtd-02.txt">';
            $this->output .= (string) '<iCalendar>';
            if (count($this->icalevents) > 0) {
                $this->output .= (string) '<vCalendar version="2.0" prodid="' . $this->prodid . '" method="' . $this->getMethod() . '">';
                $eventkeys = (array) array_keys($this->icalevents);
                foreach ($eventkeys as $id) {
                    $this->output .= (string) '<vevent>';
                    $event =& $this->icalevents[$id];
                    $this->output .= (string) $this->generateAttendeesOutput($event->getAttendees(), $format);
                    if (!isEmpty($event->getOrganizerMail())) {
                        $name = '';
                        if (!isEmpty($event->getOrganizerName())) {
                            $name = (string) ' cn="' . $event->getOrganizerName() . '"';
                        } // end if
                        $this->output .= (string) '<organizer' . $name . '>MAILTO:' . $event->getOrganizerMail() . '</organizer>';
                    } // end if
                    $this->output .= (string) '<dtstart>' . $event->getStartDate() . '</dtstart>';

                    if (strlen(trim($event->getEndDate())) > 0) {
                        $this->output .= (string) '<dtend>' . $event->getEndDate() . '</dtend>';
                    } // end if
                    if ($event->getFrequency() > 0) {
                        $this->output .= (string) '<rrule>FREQ=' . $this->getFrequencyName($event->getFrequency());
                        if (is_string($event->getRecEnd())) {
                            $this->output .= (string) ";UNTIL=" . $event->getRecEnd();
                        } elseif (is_int($event->getRecEnd())) {
                            $this->output .= (string) ";COUNT=" . $event->getRecEnd();
                        } // end if
                        $this->output .= (string) ";INTERVAL=" . $event->getInterval() . ";BYDAY=" . $event->getDays() . ";WKST=" . $event->getWeekStart() . '</rrule>';
                    } // end if
                    if (!isEmpty($event->getExeptDates())) {
                        $this->output .= (string) '<exdate>' . $event->getExeptDates() . '</exdate>';
                    } // end if
                    $this->output .= (string) '<location>' . $event->getLocation() . '</location>';
                    $this->output .= (string) '<transp>' . $event->getTransp() . '</transp>';
                    $this->output .= (string) '<sequence>' . $event->getSequence() . '</sequence>';
                    $this->output .= (string) '<uid>' . $event->getUID() . '</uid>';
                    $this->output .= (string) '<dtstamp>' . $this->ical_timestamp . '</dtstamp>';
                    if (!isEmpty($event->getCategories())) {
                        $this->output .= (string) '<categories>';
                        foreach ($event->getCategoriesArray() as $item) {
                            $this->output .= (string) '<item>' . $item . '</item>';
                        } // end foreach
                        $this->output .= (string) '</categories>';
                    } // end if
                    if (!isEmpty($event->getDescription())) {
                        $this->output .= (string) '<description>' . $event->getDescription() . '</description>';
                    } // end if
                    $this->output .= (string) '<summary>' . $event->getSummary() . '</summary>';
                    $this->output .= (string) '<priority>' . $event->getPriority() . '</priority>';
                    $this->output .= (string) '<class>' . $this->getClassName($event->getClass()) . '</class>';
                    if (!isEmpty($event->getURL())) {
                        $this->output .= (string) '<url>' . $event->getURL() . '</url>';
                    } // end if
                    if (!isEmpty($event->getStatus())) {
                        $this->output .= (string) '<status>' . $this->getStatusName($event->getStatus()) . '</status>';
                    } // end if
                    $this->output .= (string) $this->generateAlarmOutput($event->getAlarm(), $format);
                    $this->output .= (string) '</vevent>';
                } // end foreach event
                $this->output .= (string) '</vCalendar>';
            } // end if count($this->icalevents) > 0
            if (count($this->icaltodos) > 0) {
                $this->output .= (string) '<vCalendar version="2.0" prodid="' . $this->prodid . '" method="' . $this->getMethod() . '">';
                $todokeys = (array) array_keys($this->icaltodos);
                foreach ($todokeys as $id) {
                    $this->output .= (string) '<vtodo>';
                    $todo =& $this->icaltodos[$id];
                    $this->output .= (string) $this->generateAttendeesOutput($todo->getAttendees(), $format);
                    if (!isEmpty($todo->getOrganizerMail())) {
                        $name = '';
                        if (!isEmpty($todo->getOrganizerName())) {
                            $name = (string) ' cn="' . $todo->getOrganizerName() . '"';
                        } // end if
                        $this->output .= (string) '<organizer' . $name . '>MAILTO:' . $todo->getOrganizerMail() . '</organizer>';
                    } // end if
                    if (!isEmpty($todo->getStartDate())) {
                        $this->output .= (string) '<dtstart>' . $todo->getStartDate() . '</dtstart>';
                    } // end if
                    if (!isEmpty($todo->getCompleted())) {
                        $this->output .= (string) '<completed>' . $todo->getCompleted() . '</completed>';
                    } // end if
                    if (!isEmpty($todo->getDuration()) && $todo->getDuration() > 0) {
                        $this->output .= (string) '<duration>PT' . $todo->getDuration() . 'M</duration>';
                    } // end if
                    if (!isEmpty($todo->getLocation())) {
                        $this->output .= (string) '<location>' . $todo->getLocation() . '</location>';
                    } // end if
                    $this->output .= (string) '<sequence>' . $todo->getSequence() . '</sequence>';
                    $this->output .= (string) '<uid>' . $todo->getUID() . '</uid>';
                    $this->output .= (string) '<dtstamp>' . $this->ical_timestamp . '</dtstamp>';
                    if (!isEmpty($todo->getCategories())) {
                        $this->output .= (string) '<categories>';
                        foreach ($todo->getCategoriesArray() as $item) {
                            $this->output .= (string) '<item>' . $item . '</item>';
                        } // end foreach
                        $this->output .= (string) '</categories>';
                    } // end if
                    if (!isEmpty($todo->getDescription())) {
                        $this->output .= (string) '<description>' . $todo->getDescription() . '</description>';
                    } // end if
                    $this->output .= (string) '<summary>' . $todo->getSummary() . '</summary>';
                    $this->output .= (string) '<priority>' . $todo->getPriority() . '</priority>';
                    $this->output .= (string) '<class>' . $this->getClassName($todo->getClass()) . '</class>';
                    if (!isEmpty($todo->getURL())) {
                        $this->output .= (string) '<url>' . $todo->getURL() . '</url>';
                    } // end if
                    if (!isEmpty($todo->getStatus())) {
                        $this->output .= (string) '<status>' . $this->getStatusName($todo->getStatus()) . '</status>';
                    } // end if
                    if (!isEmpty($todo->getPercent()) && $todo->getPercent() > 0) {
                        $this->output .= (string) '<percent>' . $todo->getPercent() . '</percent>';
                    } // end if
                    if (!isEmpty($todo->getLastMod())) {
                        $this->output .= (string) '<last-modified>' . $todo->getLastMod() . '</last-modified>';
                    } // end if
                    if ($todo->getFrequency() > 0) {
                        $this->output .= (string) '<rrule>FREQ=' . $this->getFrequencyName($todo->getFrequency());
                        if (is_string($todo->getRecEnd())) {
                            $this->output .= (string) ";UNTIL=" . $todo->getRecEnd();
                        } elseif (is_int($todo->getRecEnd())) {
                            $this->output .= (string) ";COUNT=" . $todo->getRecEnd();
                        } // end if
                        $this->output .= (string) ";INTERVAL=" . $todo->getInterval() . ";BYDAY=" . $todo->getDays() . ";WKST=" . $todo->getWeekStart() . '</rrule>';
                    } // end if
                    if (!isEmpty($todo->getExeptDates())) {
                        $this->output .= (string) '<exdate>' . $todo->getExeptDates() . '</exdate>';
                    } // end if
                    $this->output .= (string) $this->generateAlarmOutput($todo->getAlarm(), $format);
                    $this->output .= (string) '</vtodo>';
                } // end foreach event
                $this->output .= (string) '</vCalendar>';
            } // end if count($this->icaljournals) > 0
            if (count($this->icaljournals) > 0) {
                $this->output .= (string) '<vCalendar version="2.0" prodid="' . $this->prodid . '" method="' . $this->getMethod() . '">';
                $journalkeys = (array) array_keys($this->icaljournals);
                foreach ($journalkeys as $id) {
                    $this->output .= (string) '<vjournal>';
                    $journal =& $this->icaljournals[$id];
                    $this->output .= (string) $this->generateAttendeesOutput($journal->getAttendees(), $format);
                    if (!isEmpty($journal->getOrganizerMail())) {
                        $name = '';
                        if (!isEmpty($journal->getOrganizerName())) {
                            $name = (string) ' cn="' . $journal->getOrganizerName() . '"';
                        } // end if
                        $this->output .= (string) '<organizer' . $name . '>MAILTO:' . $journal->getOrganizerMail() . '</organizer>';
                    } // end if
                    if (!isEmpty($journal->getStartDate())) {
                        $this->output .= (string) '<dtstart>' . $journal->getStartDate() . '</dtstart>';
                    } // end if
                    if (!isEmpty($journal->getCreated()) && $journal->getCreated() > 0) {
                        $this->output .= (string) '<created>' . $journal->getCreated() . '</created>';
                    } // end if
                    if (!isEmpty($journal->getLastMod()) && $journal->getLastMod() > 0) {
                        $this->output .= (string) '<last-modified>' . $journal->getLastMod() . '</last-modified>';
                    } // end if
                    $this->output .= (string) '<sequence>' . $journal->getSequence() . '</sequence>';
                    $this->output .= (string) '<uid>' . $journal->getUID() . '</uid>';
                    $this->output .= (string) '<dtstamp>' . $this->ical_timestamp . '</dtstamp>';
                    if (!isEmpty($journal->getCategories())) {
                        $this->output .= (string) '<categories>';
                        foreach ($journal->getCategoriesArray() as $item) {
                            $this->output .= (string) '<item>' . $item . '</item>';
                        } // end foreach
                        $this->output .= (string) '</categories>';
                    } // end if
                    if (!isEmpty($journal->getDescription())) {
                        $this->output .= (string) '<description>' . $journal->getDescription() . '</description>';
                    } // end if
                    $this->output .= (string) '<summary>' . $journal->getSummary() . '</summary>';
                    $this->output .= (string) '<class>' . $this->getClassName($journal->getClass()) . '</class>';
                    if (!isEmpty($journal->getURL())) {
                        $this->output .= (string) '<url>' . $journal->getURL() . '</url>';
                    } // end if
                    if (!isEmpty($journal->getStatus())) {
                        $this->output .= (string) '<status>' . $this->getStatusName($journal->getStatus()) . '</status>';
                    } // end if
                    if ($journal->getFrequency() != 'ONCE') {
                        $this->output .= (string) '<rrule>FREQ=' . $journal->getFrequency();
                        if (is_string($journal->getRecEnd())) {
                            $this->output .= (string) ";UNTIL=" . $journal->getRecEnd();
                        } elseif (is_int($journal->getRecEnd())) {
                            $this->output .= (string) ";COUNT=" . $journal->getRecEnd();
                        } // end if
                        $this->output .= (string) ";INTERVAL=" . $journal->getInterval() . ";BYDAY=" . $journal->getDays() . ";WKST=" . $journal->getWeekStart() . '</rrule>';
                    } // end if
                    if (!isEmpty($journal->getExeptDates())) {
                        $this->output .= (string) '<exdate>' . $journal->getExeptDates() . '</exdate>';
                    } // end if
                    $this->output .= (string) '</vjournal>';
                } // end foreach event
                $this->output .= (string) '</vCalendar>';
            } // end if count($this->icaltodos) > 0
            if (count($this->icalfbs) > 0) {
                $this->output .= (string) '<vCalendar version="2.0" prodid="' . $this->prodid . '" method="' . $this->getMethod() . '">';
                $fbkeys = (array) array_keys($this->icalfbs);
                foreach ($fbkeys as $id) {
                    $this->output .= (string) '<vfreebusy>';
                    $fb =& $this->icalfbs[$id];
                    $this->output .= (string) $this->generateAttendeesOutput($fb->getAttendees(), $format);
                    if (!isEmpty($fb->getOrganizerMail())) {
                        $name = '';
                        if (!isEmpty($fb->getOrganizerName())) {
                            $name = (string) ' cn="' . $fb->getOrganizerName() . '"';
                        } // end if
                        $this->output .= (string) '<organizer' . $name . '>MAILTO:' . $fb->getOrganizerMail() . '</organizer>';
                    } // end if
                    if (!isEmpty($fb->getStartDate())) {
                        $this->output .= (string) '<dtstart>' . $fb->getStartDate() . '</dtstart>';
                    } // end if
                    if (!isEmpty($fb->getEndDate())) {
                        $this->output .= (string) '<dtend>' . $fb->getEndDate() . '</dtend>';
                    } // end if
                    if (!isEmpty($fb->getDuration()) && $fb->getDuration() > 0) {
                        $this->output .= (string) '<duration>PT' . $fb->getDuration() . 'M</duration>';
                    } // end if
                    $this->output .= (string) '<uid>' . $fb->getUID() . '</uid>';
                    $this->output .= (string) '<dtstamp>' . $this->ical_timestamp . '</dtstamp>';
                    if (!isEmpty($fb->getURL())) {
                        $this->output .= (string) '<url>' . $fb->getURL() . '</url>';
                    } // end if
                    if (count($fb->getFBTimes()) > 0) {
                        foreach ($fb->getFBTimes() as $timestamp => $data) {
                            $values = (array) explode(',',$data);
                            $this->output .= (string) '<freebusy fbtype="' . $values[1] . '">' . $timestamp . '/' . $values[0] . '</freebusy>';
                        } // end foreach
                        unset($values);
                    } // end if
                    $this->output .= (string) '</vfreebusy>';
                } // end foreach event
                $this->output .= (string) '</vCalendar>';
            } // end if count($this->icaltodos) > 0
            $this->output .= (string) '</iCalendar>';
        } // end if xcs
        elseif ($this->output_format == 'rdf') {
            $this->output  = (string) '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
            $this->output .= (string) '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/10/swap/pim/ical#" xmlns:i="http://www.w3.org/2000/10/swap/pim/ical#">';
            $this->output .= (string) '<Vcalendar rdf:about="">';
            $this->output .= (string) '<version>2.0</version>';
            $this->output .= (string) '<prodid>' . $this->prodid . '</prodid>';
            $this->output .= (string) '</Vcalendar>';
            $eventkeys = (array) array_keys($this->icalevents);
            foreach ($eventkeys as $id) {
                $event =& $this->icalevents[$id];
                $this->output .= (string) '<Vevent>';
                $this->output .= (string) '<uid>' . $event->getUID() . '</uid>';
                $this->output .= (string) '<summary>' . $event->getSummary() . '</summary>';
                if (!isEmpty($event->getDescription())) {
                    $this->output .= (string) '<description>' . $event->getDescription() . '</description>';
                } // end if
                if (!isEmpty($event->getCategories())) {
                    $this->output .= (string) '<categories>' . $event->getCategories() . '</categories>';
                } // end if
                $this->output .= (string) '<status/>';
                $this->output .= (string) '<class resource="http://www.w3.org/2000/10/swap/pim/ical#private"/>';
                $this->output .= (string) '<dtstart parseType="Resource">';
                $this->output .= (string) '<value>' . $event->getStartDate() . '</value>';
                $this->output .= (string) '</dtstart>';
                $this->output .= (string) '<dtstamp>' . $this->ical_timestamp . '</dtstamp>';
                $this->output .= (string) '<due/>';
                $this->output .= (string) '</Vevent>';
            } // end foreach event
            $this->output .= (string) '</rdf:RDF>';
        } // end if rdf
        if (isset($event)) {
            unset($event);
        }
    } // end function

}
?>