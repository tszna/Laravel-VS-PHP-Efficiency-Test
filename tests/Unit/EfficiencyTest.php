<?php

namespace Tests\Unit;

use App\Models\Car;
use App\Models\User;
use Tests\TestCase;

class EfficiencyTest extends TestCase
{
    /**
     * @return void
     */
    public function test_eloquent()
    {        
        $executionTime = $this->getExecutionTime(function () {            
            User::query()->with('cars')->get();            
        });
        echo 'eloquent speed: '. $executionTime;
        echo "\n";
        $this->assertTrue(true);
    }

    public function test_raw_php()
    {
        $executionTime = $this->getExecutionTime(function () {            
            $connection = new \PDO('mysql:dbname=efficiency_test;hostname=localhost;port=3308;charset=utf8', 'efficiency_test', 'efficiency_test');

            $query = 'SELECT * FROM users';

            $users = $connection->query($query)->fetchAll(\PDO::FETCH_ASSOC);
            
            $queryCars = 'SELECT * FROM cars';
            $cars = $connection->query($queryCars)->fetchAll(\PDO::FETCH_ASSOC);

            $usersById = [];
            foreach($users as $user) {
                $usersById[$user['id']] = $user;
            }

            foreach ($cars as &$car) {
                $usersById[$car['user_id']]['cars'][] = $car;
            }      
            
        });
        echo 'raw PHP speed: ' . $executionTime;
        echo "\n";
        $this->assertTrue(true);
    }

    /**
     * @return void
     */
    public function test_ram_eloquent()
    {
        $this->getExecutionTime(function () {
            $m1 = memory_get_usage();
            $x = Car::query()->with('user')->get();
            $m2 = memory_get_usage();            
            echo 'RAM usage of eloquent: '. round(($m2 - $m1) / 1024 / 1024, 2) . ' MB';
            echo "\n";
            foreach ($x as $xx) {
                //
            }
        });
        
        $this->assertTrue(true);
    }

    public function test_ram_raw_php()
    {
        $this->getExecutionTime(function () {
            $m1 = memory_get_usage();
            $connection = new \PDO('mysql:dbname=efficiency_test;hostname=localhost;port=3308;charset=utf8', 'efficiency_test', 'efficiency_test');

            $query = 'SELECT * FROM users';

            $users = $connection->query($query)->fetchAll(\PDO::FETCH_ASSOC);
            
            $queryCars = 'SELECT * FROM cars';
            $cars = $connection->query($queryCars)->fetchAll(\PDO::FETCH_ASSOC);

            $usersById = [];
            foreach($users as $user) {
                $usersById[$user['id']] = $user;
            }

            foreach ($cars as &$car) {
                $usersById[$car['user_id']]['cars'][] = $car;
            }
            
            $m2 = memory_get_usage();            
            echo 'RAM usage of raw PHP: ' . round(($m2 - $m1) / 1024 / 1024, 2) . ' MB';
            foreach ($usersById as $xx) {
                //
            }
        });
        
        $this->assertTrue(true);
    }


    private function getExecutionTime($func)
    {
        $start = microtime(true);
        
        $func();
        
        $end = microtime(true);

        return round(($end - $start) * 1000) . ' ms';
    }
}
