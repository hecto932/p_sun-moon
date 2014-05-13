<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package        CodeIgniter
 * @author        Rick Ellis
 * @copyright    Copyright (c) 2006, EllisLab, Inc.
 * @license        http://www.codeignitor.com/user_guide/license.html
 * @link        http://www.codeigniter.com
 * @since        Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Geo Locater
 *
 * This class enables you to locate a user in the world based on IP Address
 *
 * package        CodeIgniter
 * subpackage    Libraries
 * category    Libraries
 * author        Ross Monge (Antivanity on freenode)
 * link        http://codeigniter.com/wiki/Geo_Locater/
 */
class CI_Geolocater {

    var $CI;

    // --------------------------------------------------------------------

    /**
     * Get CodeIgniter Instance
     *
     * @access    private
     * @return    void
     */

    function CI_Geolocater ()
    {
        $this->CI =& get_instance();
    }
     
    // --------------------------------------------------------------------

    /**
     * Get geo location from IP Address
     *
     * This function always gets the country. Getting the city is optional by param.
     *
     * access    public
     * param    string        $int_ipaddress        IP Address to look up
     * param    boolean        $bol_returnCity        Return city or not
     * return    void
     */

    function getlocation($int_ipaddress, $bol_returnCity = FALSE)
    {

        // Separate IP Address by Class A/B/C/D
        $arr_ipAddress = explode('.',$int_ipaddress);        

        // Set table to use based on IP Address Class A
        $str_ipTable = 'ip4_' . $arr_ipAddress[0];
        
        $this->CI->db->select('countries.name AS country');

        if ($bol_returnCity)
        {
            // Check if city should be returned, then selected it from query
            $this->CI->db->select('cityByCountry.name AS city');
        }
        
        $this->CI->db->from($str_ipTable);

        $this->CI->db->join('countries', $str_ipTable . '.country = countries.id');
        
        if ($bol_returnCity)
        {
            // Table join needed to get city name
            $this->CI->db->join('cityByCountry', $str_ipTable . '.country = cityByCountry.country AND ' . $str_ipTable . '.city = cityByCountry.city');
        }
        
        // Set Where based on Class B of IP Address
        $this->CI->db->where($str_ipTable . '.b', $arr_ipAddress[1]);

        // Set Where based on Class C of IP Address
        $this->CI->db->where($str_ipTable . '.c', $arr_ipAddress[2]);

        $obj_query = $this->CI->db->get();

        return $obj_query->result();
        
    }
}

// END CI_Geolocater class

?>