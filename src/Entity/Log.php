<?php

namespace App\Entity;

use App\Repository\LogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LogRepository::class)
 */
class Log
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $event_name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $request_type_v1;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $request_type_v2;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $request_method;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $base_url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uri_path_info;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uri_query_string;

    /**
     * @ORM\Column(type="string", length=300)
     */
    private $full_uri;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $method_correct;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $uri_age_param_set;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $controller;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $router;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $client_ip;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $router_parameters;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $json_data;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $request_format;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventName(): ?string
    {
        return $this->event_name;
    }

    public function setEventName(string $event_name): self
    {
        $this->event_name = $event_name;

        return $this;
    }

    public function getRequestTypeV1(): ?string
    {
        return $this->request_type_v1;
    }

    public function setRequestTypeV1(?string $request_type_v1): self
    {
        $this->request_type_v1 = $request_type_v1;

        return $this;
    }

    public function getRequestTypeV2(): ?string
    {
        return $this->request_type_v2;
    }

    public function setRequestTypeV2(?string $request_type_v2): self
    {
        $this->request_type_v2 = $request_type_v2;

        return $this;
    }

    public function getRequestMethod(): ?string
    {
        return $this->request_method;
    }

    public function setRequestMethod(string $request_method): self
    {
        $this->request_method = $request_method;

        return $this;
    }

    public function getBaseUrl(): ?string
    {
        return $this->base_url;
    }

    public function setBaseUrl(string $base_url): self
    {
        $this->base_url = $base_url;

        return $this;
    }

    public function getUriPathInfo(): ?string
    {
        return $this->uri_path_info;
    }

    public function setUriPathInfo(string $uri_path_info): self
    {
        $this->uri_path_info = $uri_path_info;

        return $this;
    }

    public function getUriQueryString(): ?string
    {
        return $this->uri_query_string;
    }

    public function setUriQueryString(string $uri_query_string): self
    {
        $this->uri_query_string = $uri_query_string;

        return $this;
    }

    public function getFullUri(): ?string
    {
        return $this->full_uri;
    }

    public function setFullUri(string $full_uri): self
    {
        $this->full_uri = $full_uri;

        return $this;
    }

    public function getMethodCorrect(): ?string
    {
        return $this->method_correct;
    }

    public function setMethodCorrect(string $method_correct): self
    {
        $this->method_correct = $method_correct;

        return $this;
    }

    public function getUriAgeParamSet(): ?string
    {
        return $this->uri_age_param_set;
    }

    public function setUriAgeParamSet(string $uri_age_param_set): self
    {
        $this->uri_age_param_set = $uri_age_param_set;

        return $this;
    }

    public function getController(): ?string
    {
        return $this->controller;
    }

    public function setController(string $controller): self
    {
        $this->controller = $controller;

        return $this;
    }

    public function getRouter(): ?string
    {
        return $this->router;
    }

    public function setRouter(string $router): self
    {
        $this->router = $router;

        return $this;
    }

    public function getClientIp(): ?string
    {
        return $this->client_ip;
    }

    public function setClientIp(string $client_ip): self
    {
        $this->client_ip = $client_ip;

        return $this;
    }

    public function getRouterParameters(): ?string
    {
        return $this->router_parameters;
    }

    public function setRouterParameters(?string $router_parameters): self
    {
        $this->router_parameters = $router_parameters;

        return $this;
    }

    public function getJsonData(): ?string
    {
        return $this->json_data;
    }

    public function setJsonData(string $json_data): self
    {
        $this->json_data = $json_data;

        return $this;
    }

    public function getRequestFormat(): ?string
    {
        return $this->request_format;
    }

    public function setRequestFormat(string $request_format): self
    {
        $this->request_format = $request_format;

        return $this;
    }
}
