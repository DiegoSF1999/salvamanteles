<?php

namespace App\Helpers;

use App\Restaurant;

class RestaurantReader
{
    function __construct()
    {
        
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
            foreach ($fila as $key => $value) {
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

        for ($i = 0; $i < count($$namesList); $i++) {
            try {
                $restaurant = new Restaurant();
                $restaurant->name = $namesList[$i];
                $restaurant->icon = $iconsList[$i];
                $restaurant->save();
            } catch (\Throwable $th) {
            }
        }
    }
    public function Execute()
    {
        $both_arrays = $this->FileReader();
        $this->showRestaurants($both_arrays);
    }
}
