<?php

use App\Helpers\RestaurantReader;
use App\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    //$counter = 0;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->Execute();
    }

    public function FileReader()
    {
        $restaurantsNamesList = [];
        $restaurantsIconsList = [];

        $CSVfile = fopen('./storage/app/public/restaurants-document.csv', 'r');
        $delimitador = ",";
        if (!$CSVfile) {
            exit("No se puede abrir el archivo $CSVfile");
        }
        fgetcsv($CSVfile);
        while ($fila = fgetcsv($CSVfile, $delimitador)) {
            for ($i = 1; $i < count($fila); $i++) {
                array_push($restaurantsNamesList, $fila[0]);
                array_push($restaurantsIconsList, $fila[1]);
            }
        }
        fclose($CSVfile);

        $both_arrays = [$restaurantsNamesList, $restaurantsIconsList];

        return $both_arrays;
    }

    public function showRestaurants($both_arrays)
    {
        $namesList = $both_arrays[0];
        $iconsList = $both_arrays[1];
        $counter = count($namesList);

        //   print($counter); exit;
        for ($i = 0; $i < $counter; $i++) {
            try {
                $restaurant = new Restaurant();
                $restaurant->name = $namesList[$i];
                $restaurant->icon = $iconsList[$i];
                $restaurant->save();
            } catch (\Throwable $th) {
            }
        }
        print_r($both_arrays);
    }
    public function Execute()
    {
        $both_arrays = $this->FileReader();
        $this->showRestaurants($both_arrays);
    }
}
