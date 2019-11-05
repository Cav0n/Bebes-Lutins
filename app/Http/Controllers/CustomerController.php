<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Search a user
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search_words = preg_split('/\s+/', $request['search']);

        $found_valid_customers = array();
        $found_possible_customers = array();
        $result = array();

        $customers = User::where('id', '!=', null)->orderBy('firstName', 'asc')->orderBy('lastName', 'asc')->get();
        $total_valid_words = count($search_words);

        foreach($customers as $customer){
            $count_valid_words = 0;
            $customer->phone = chunk_split($customer->phone, 2, " ");
            foreach($search_words as $word) {
                if (stripos(mb_strtoupper($customer->firstname),mb_strtoupper($word)) !== false) $count_valid_words++;
                else if (stripos(mb_strtoupper($customer->lastname),mb_strtoupper($word)) !== false) $count_valid_words++;
                else if (stripos(mb_strtoupper($customer->phone),mb_strtoupper($word)) !== false) $count_valid_words++;
            }
            if($count_valid_words == $total_valid_words) {$found_valid_customers[$customer->id] = $customer;}
            else if($count_valid_words > 0) $found_possible_customers[] = $customer;
        }
        
        $result['valid_customers'] = $found_valid_customers;
        $result['possible_customers'] = $found_possible_customers;
        $result['valid_results_nb'] = count($found_valid_customers);

        header('Content-type: application/json');
        echo json_encode( $result, JSON_PRETTY_PRINT);
    }
}
