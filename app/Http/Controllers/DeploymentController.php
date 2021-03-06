<?php

namespace App\Http\Controllers;

use function file_get_contents;
use function http_response_code;
use Illuminate\Http\Request;
use function shell_exec;

/**
 * Class DeploymentController
 * @package App\Http\Controllers
 */
class DeploymentController extends Controller
{
    /**
     * @param Request $request
     */
    public function deploy(Request $request)
    {
    $commands=['cd /var/www/chuanqi','git pull'];
        $signature = $request->header('X-Hub-Signature');
        $payload = file_get_contents('php://input');
        if($this->isFromGithub($payload,$signature)){
            foreach($commands as $command){
                shell_exec($command);
            }
            http_response_code(200);
        }else{
            abort(403);
        }
    }

    /**
     * @param $payload
     * @param $signature
     * @return bool
     */
    private function isFromGithub($payload, $signature)
    {
    return 'sha1=' . hash_hmac('sha1',$payload,env('GITHUB_DEPLOY_TOKEN'),false)===$signature;
    }
}
