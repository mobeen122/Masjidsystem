<?php
namespace App;

/**
 *
 * @author Asif
 *
 */
trait Util
{
    /**
     * Function to Display the date on the website
     * If no date given then displays today's date
     * @param \DateTime $date
     * @return boolean
     */
    public static function Displaydate($date = null)
    {
        if ($date == null)
        {
             $t = new \DateTime();
             return $t->format('jS M Y');
        }
        else
        {
            if (strtotime($date) === false)
            {
                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('jS M Y');
            }
        }
    }
    /**
     * Function to Display Date and Time from a date given on web page
     * If no date given then displays today's date and time
     * @param date Date
     */
    public static function DisplayDateTime($date = null)
    {
        if ($date == null)
        {
            $t = new \DateTime();
            return $t->format('jS F Y H:i:s');
        }
        else
        {
            if (strtotime($date) === false)
            {
                
                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('jS F Y H:i:s');
            }
        }
    }

    /**
     * Function to Change the date on the website
     * If no date given then displays today's date
     * @param \DateTime $date
     * @return boolean
     */
    public static function changedate($date)
    {
        if ($date == null)
        {
            return null;
        }
        else
        {
            $t = new \DateTime($date);
            return $t->format('d-m-Y');
        }
    }
    /**
     * Function to Add Given Date or Todays Date to Database
     */
    public static function AddDate($date = null)
    {
        if ($date == null)
        {
            $dt = new \DateTime();
            return $dt->format('Y-m-d');
        }
        else
        {
            if (strtotime($date) === false)
            {
                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('Y-m-d');
            }
        }
    }

    /**
     * Function to Add Given Date or Todays Date to Database
     */
    public static function AddDateTime($date = null)
    {
        if ($date == null)
        {
            $dt = new \DateTime();
            return $dt->format('Y-m-d H:i:s');
        }
        else
        {
            if (strtotime($date) === false)
            {
                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('Y-m-d H:i:s');
            }
        }
    }

    /**
     * Format and return currency to 2 decimal points
     * @param int, double $total
     * @param string $precision
     * @return number to 2 decimal points
     */
    public static function currencyFormat($total, $precision=PHP_ROUND_HALF_UP)
    {
        return \round($total, 2, $precision);
    }
    /**
     * Get next monday of the week
     * @param DateTime $date Provide a date to get next monday
     */
    public static function GetNextMonday($date = null)
    {
    
        if ($date == null)
        {
            $t = new \DateTime();
            return $t->modify('next monday')->format('Y-m-d');
        }
        else
        {
            if (strtotime($date) === false)
            {
                 $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->modify('next monday')->format('Y-m-d');
            }
        }
    }
    /**
     * Get Sunday of the week
     * @param DateTime $date Provide a date to get next Sunday
     */
    public static function GetNextSunday($date = null)
    {
    
        if ($date == null)
	    {
	       $t      = new \DateTime($date);
	       $td     = new \DateTime();
	       $today  = $t->format('w');
	       if ($today == 0)
	       {
                $sundays =  $td->format('d-m-Y');
           }
	       else
	       {
	           $sundays = $t->modify('next sunday')->format('d-m-Y');
	       }
	       return $sundays;
	    }
	    else
	    {
	        if (strtotime($date) === false)
	        {
	            //Session::set_flash('error', 'Invalid Date Given');
	            return false;
	        }
	        else
	        {
	            $t = new \DateTime($date);
	            $td = new \DateTime();
	            $today = $t->format('w');
	            if ($today == 0)
	            {
	               $sundays =  $td->format('d-m-Y');
	            }
	            else
	            {
	                $sundays = $t->modify('next sunday')->format('d-m-Y');
	            }
	            return $sundays;
	        }
	    }
    }
    /**
     * get day of the week from a given date or todays day
     * @param datetime $date
     */
    public static function GetDayOfWeek($date = Null)
    {
        if ($date == null)
        {
            $dt = new \DateTime();
            return $dt->format('N');
        }
        else
        {
            if (strtotime($date) === false)
            {
                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('N');
            }
        }
    }
    
    public static function array_combine2($arr1, $arr2) {
        $count = min(count($arr1), count($arr2));
        return array_combine(array_slice($arr1, 0, $count), array_slice($arr2, 0, $count));
    }
    public static function csv_to_array($filename='', $delimiter=',')
    {
        ini_set('auto_detect_line_endings',TRUE);
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;
    
        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if (!$header) {
                    $header = $row;
                }
                else {
                    if (count($header) > count($row)) {
                        $difference = count($header) - count($row);
                        for ($i = 1; $i <= $difference; $i++) {
                            $row[count($row) + 1] = $delimiter;
                        }
                    }
                    
                    $data[] = self::array_combine2($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }

    /**
     * Set JSON response for AJAX, API request
     *
     * @param  string  $content
     * @param  integer $statusCode
     * @param  string  $statusMessage
     *
     * @return \Phalcon\Http\Response
     */
    public function jsonResponse($content, $statusCode = 200, $statusMessage = 'OK')
    {
        // Encode content
        $content = json_encode($content);
    
        // Create a response since it's an ajax
        $response = new \Phalcon\Http\Response();
        $response->setStatusCode($statusCode, $statusMessage);
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent($content);
    
        return $response;
    }
    
    public static function Uppercase($text = null)
    {
        if ($text != null )
        {
            return strtoupper($text);
        }
        
    }

    public static function closest($array, $number) 
    {
            foreach ($array as $a => $t) {
                if ($number <= $a) {
                    return $t;
                    break;
                }
            }
            return end($array); // or return NULL;
   }
}


/* public function afterExecuteRoute($dispatcher) {
    $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    if ($is_ajax) {
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);

        $eventsManager = new \Phalcon\Events\Manager();

        $eventsManager->attach('view:afterRender', function ($event, $view) {
            $view->setContent(json_encode(array(
                'content' => $view->getContent(),
                'title' => \Phalcon\Tag::getTitle(false)
            )));
        });

            $this->view->setEventsManager($eventsManager);
            $this->response->setHeader('Content-Type', 'text/plain');
    }
} */
