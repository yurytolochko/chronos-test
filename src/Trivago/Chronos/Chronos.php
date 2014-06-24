<?php

namespace Trivago\Chronos;

class Chronos
{
    /**
     * @var string
     */
    protected $host;

    public function __construct($host = 'localhost:4400')
    {
        $this->host = $host;
    }

    public function getJobs()
    {
        return $this->execute('GET', '/scheduler/jobs');
    }

    public function deleteJob($name)
    {
        return $this->execute('DELETE', '/scheduler/job/' . $name);
    }

    public function deleteJobTasks($name)
    {
        return $this->execute('DELETE', '/scheduler/task/kill/' . $name);
    }

    public function startJob($name)
    {
        return $this->execute('PUT', '/scheduler/job/' . $name);
    }

    public function createJob(array $job)
    {
        return $this->execute('POST', '/scheduler/iso8601', $job);
    }

    public function completeAsyncJob($taskId, $status = 0)
    {
        return $this->execute('PUT', '/scheduler/task/' . $taskId, ['statusCode' => $status]);
    }


    /**
     * @param string $method GET|POST|DELETE|PUT
     * @param string $url
     * @param array $data
     * @return mixed|null
     * @throws \Exception
     */
    public function execute($method, $url, $data = null)
    {
        $content = json_encode($data);

        $ch = curl_init($this->host . $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($content)
        ));

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }

        if (empty($result)) {
            return null;
        }

        return json_decode($result);
    }
}