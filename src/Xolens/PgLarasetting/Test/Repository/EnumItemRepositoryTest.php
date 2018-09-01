<?php

namespace Xolens\PgLarasetting\Test\Repository;

use Xolens\PgLarasetting\App\Repository\EnumItemRepository;
use Xolens\PgLarasetting\App\Repository\EnumGroupRepository;

use Xolens\PgLarasetting\App\Model\EnumItem;

use Xolens\LarautilContract\App\Util\Model\Sorter;
use Xolens\LarautilContract\App\Util\Model\Filterer;

final class EnumItemRepositoryTest extends TestPgLaraSettingBase
{
    protected $enumGroupRepo;
    /**
     * Setup the test environment.
     */
    protected function setUp(): void{
        parent::setUp();
        $this->artisan('migrate');
        $repo = new EnumItemRepository();
        $this->repo = $repo;
        $this->enumGroupRepo = new EnumGroupRepository();
    }

    /**
     * @test
     */
    public function test_make(){
        $i = rand(0, 10000);
        $item = $this->repository()->make([
            "enum_group_id"=> $i,
            "label"=> "label".$i,
            "value"=> "value".$i,
        ]);
        $this->assertTrue(true);
    }
    
    /** HELPERS FUNCTIONS --------------------------------------------- **/

    public function generateSorter(){
        $sorter = new Sorter();
        $sorter->asc('label')
                ->asc('value');
        return $sorter;
    }

    public function generateFilterer(){
        $filterer = new Filterer();
        $filterer->between('id',[0,14])
                ->like('label','%tab%');
        return $filterer;
    }

    public function generateItems($toGenerateCount){
        $count = $this->repository()->count()->response();
        $generatedItemsId = [];
        
        for($i=$count; $i<($toGenerateCount+$count); $i++){
            $enumGroupId = $this->enumGroupRepo->model()::inRandomOrder()->first()->id;
            $item = $this->repository()->create([
                "enum_group_id"=> $enumGroupId,
                "label"=> "label".$i,
                "value"=> "value".$i,
            ]);
            $generatedItemsId[] = $item->response()->id;
        }
        $this->assertEquals(count($generatedItemsId), $toGenerateCount);
        return $generatedItemsId;
    }
}