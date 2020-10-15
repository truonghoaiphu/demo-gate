<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-08-26
 * Time: 22:36
 */

namespace Katniss\Everdeen\Http\Controllers\WebApi;

use Katniss\Everdeen\Exceptions\KatnissException;
use Katniss\Everdeen\Http\Controllers\WebApiController;
use Katniss\Everdeen\Http\Request;
use Katniss\Everdeen\Repositories\UserRepository;

class UserController extends WebApiController
{
    protected $userRepository;

    public function __construct()
    {
        parent::__construct();

        $this->userRepository = new UserRepository();
    }

    public function index(Request $request)
    {
        return $this->responseFail();
    }

    public function getCsrfToken()
    {
        return $this->responseSuccess([
            'csrf_token' => csrf_token()
        ]);
    }

    public function getQuickLogin(Request $request)
    {
        if (!$this->customValidate($request, [
            'id' => 'required',
            'password' => 'required',
        ])
        ) {
            return $this->responseFail($this->getValidationErrors());
        }


        if (!auth()->attempt($request->only('id', 'password'))) {
            return $this->responseFail();
        }

        return $this->responseSuccess([
            'csrf_token' => csrf_token(),
            'user' => auth()->user()
        ]);
    }

    public function postAvatarUsingCropperJs(Request $request, $id)
    {
        $this->userRepository->model($id);

        if (!$this->customValidate($request, [
            'cropper_image_file' => 'required',
        ])
        ) {
            return $this->responseFail($this->getValidationErrors());
        }

        try {
            $user = $this->userRepository->updateAvatarByCropperJs(
                $request->file('cropper_image_file')->getRealPath(),
                $request->input('cropper_image_data')
            );

            return $this->responseSuccess([
                'store_path' => $user->url_avatar,
                'store_path_thumb' => $user->url_avatar_thumb,
            ]);
        } catch (KatnissException $ex) {
            return $this->responseFail($ex->getMessage());
        }
    }
}