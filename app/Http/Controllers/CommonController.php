<?php

namespace App\Http\Controllers;

use App\Company;
use App\Country;
use App\User;
use App\Role;
use DB;

class CommonController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        return view('operations.common');
    }

    public function fetchCountries()
    {

        $ch = curl_init();
        $url = "https://restcountries.com/v3.1/region/asia";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch,CURLOPT_POST,true);
        // curl_setopt($ch, CURLOPT_HEADER, TRUE);
        // curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
        // curl_setopt($ch,CURLOPT_POSTFIELD,"postv1 = value1&postv2 = value2");
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // get curl status code
        curl_close($ch);

        $jsonArrayResponse = json_decode($result, true);

        if (!empty($jsonArrayResponse) && $httpCode == 200) {

            foreach ($jsonArrayResponse as $key => $val) {

                $ins_array = array(
                    'country_name' => '',
                    'official_name' => '',
                    'capital' => '',
                );

                if (array_key_exists("name", $val)) {

                    if (count($val['name']) > 0) {
                        $ins_array['country_name'] = isset($val['name']['common']) ? $val['name']['common'] : '';
                        $ins_array['official_name'] = isset($val['name']['official']) ? $val['name']['official'] : '';
                    }
                }

                if (array_key_exists("capital", $val)) {
                    if (count($val['capital']) > 0) {
                        $ins_array['capital'] = isset($val['capital'][0]) ? $val['capital'][0] : '';
                    }
                }

                try {
                    // $this->buildXMLHeader();
                    // DB::table('countries')->insert($ins_array);
                    Country::insert($ins_array);
                } catch (\Exception $e) {
                    $error = $e->getMessage();
                }
            }
        } else {
            return false;
        }
    }

    public function employeeListing()
    {
        // $val = 'A';
        // $countries = DB::table('countries')->where('country_name','like',"".$val."%")->get();
        // $countries = DB::table('countries')->value('country_name');
        // $countries = DB::table('countries')->find(1);
        // $countries = DB::table('countries')->pluck('country_name','capital');
        // $countries = DB::table('countries')->count();
        // $countries = DB::table('countries')->where('country_name', 'Uzbekistan')->exists();
        // $countries = DB::table('countries')->where('country_name', 'Uzbekistan')->doesntExist();
        // -----------------------------------------------------//

        // DB::table('countries')->orderBy('id')->chunk(10, function ($countries) {
        //     foreach ($countries as $country) {
        //         print_r($country);
        //         echo PHP_EOL.'-----------------------------------------'.PHP_EOL;
        //     }
        // });

        // DB::table('countries')->whereNull('created_at')
        //     ->chunkById(10, function ($countries) {
        //         foreach ($countries as $country) {
        //             DB::table('countries')
        //                 ->where('id', $country->id)
        //                 ->update(['created_at' => Carbon::now()]);
        //         }
        // });
        // -----------------------------------------------------//

        // $countries = DB::table('countries')->distinct('country_name')->distinct('official_name')->count();

        // $query = DB::table('countries')->select('country_name');
        // $countries = $query->addSelect('official_name')->get();

        // $countries = DB::table('countries')->select('*',DB::raw('count(id) as total_count'))->groupBy('country_name')->get();

        // $countries = DB::table('countries')
        // ->select('official_name','country_name')
        // ->groupByRaw('country_name, official_name')->get();
        // -----------------------------------------------------//

        // $countries = DB::table('countries')->where([
        //     ['country_name', '<>', ''],
        //     ['official_name', '<>', ''],
        // ])->get();

        // $countries = DB::table('countries')
        //     ->where('country_name', '<>', '')
        //     ->orWhere(function($query) {
        //         $query->where('official_name', '<>', '')
        //               ->where('capital', '<>', '');
        //     })
        //     ->get();

        // The whereColumn method may be used to verify that two columns are equal:
        // $countries = DB::table('countries')
        // ->whereColumn('country_name', 'official_name') ->1
        // ->whereColumn('updated_at', '>', 'created_at') ->2
        // ->whereColumn([                                ->3
        //     ['country_name', '=', 'official_name'],
        //     ['updated_at', '>', 'created_at'],
        // ]
        // ->get();
        // -----------------------------------------------------//

        // The insertOrIgnore method will ignore duplicate record errors while inserting records into the database:
        // DB::table('users')->insertOrIgnore([
        //     ['id' => 1, 'email' => 'taylor@example.com'],
        //     ['id' => 2, 'email' => 'dayle@example.com']
        // ]);

        // $id = DB::table('users')->insertGetId(
        //     ['email' => 'john@example.com', 'votes' => 0]
        // );

        // DB::table('users')
        //     ->updateOrInsert(
        //         ['email' => 'john@example.com', 'name' => 'John'],
        //         ['votes' => '2']
        //     );
        // -----------------------------------------------------//

        $countries = DB::table('countries')->get();
        return (['countries' => $countries]);
    }

    //////one to one & one to many
    public function userCompanyDetails()
    {
        return User::find(2)->company;
        // return User::find(2)->company->where('name','Mi');

        // return Company::find(102)->user;
        // return Company::find(102)->user->name;
    }

    //////many to many
    public function userRoles()
    {
        $user = User::find(1);
        $roles = $user->roles;
        dd(json_decode($roles));

        // $role = Role::find(1);
        // $users = $role->users;
        // dd(json_decode($users));


        // ----------create records -------- //
        // $user = User::find(2);	
        // $roleIds = [1, 2];
        // $user->roles()->attach($roleIds);

        // $user = User::find(3);	
        // $roleIds = [1, 2];
        // $user->roles()->sync($roleIds);

        // $role = Role::find(1);	
        // $userIds = [10, 11];
        // $role->users()->attach($userIds);
    }
}