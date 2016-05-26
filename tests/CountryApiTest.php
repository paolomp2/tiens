<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CountryApiTest extends TestCase
{
    use MakeCountryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    function it_can_create_countries()
    {
        $country = $this->fakeCountryData();
        $this->json('POST', "/api/v1/countries", $country);

        $this->assertApiResponse($country);
    }

    /**
     * @test
     */
    function it_can_read_country()
    {
        $country = $this->makeCountry();
        $this->json("GET", "/api/v1/countries/{$country->id}");

        $this->assertApiResponse($country->toArray());
    }

    /**
     * @test
     */
    function it_can_update_country()
    {
        $country = $this->makeCountry();
        $editedCountry = $this->fakeCountryData();

        $this->json('PUT', "/api/v1/countries/{$country->id}", $editedCountry);

        $this->assertApiResponse($editedCountry);
    }

    /**
     * @test
     */
    function it_can_delete_countries()
    {
        $country = $this->makeCountry();
        $this->json("DELETE", "/api/v1/countries/{$country->id}");

        $this->assertApiSuccess();
        $this->json("GET", "/api/v1/countries/{$country->id}");

        $this->assertResponseStatus(404);
    }

}
