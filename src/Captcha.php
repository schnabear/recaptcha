<?php

/**
 * reCAPTCHA PHP Library
 *
 * Copyright (c) 2014 schnabear
 * This work is free. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar.
 * See the LICENSE.txt file for more details.
 *
 * @package   Oz\Recaptcha
 * @version   1.0
 * @author    schnabear
 * @copyright 2014 schnabear
 * @license   WTFPL
 * @link      https://github.com/schnabear/recaptcha
 */

namespace Oz\Recaptcha;

class Captcha
{
    const ELEMENT_CLASS_NAME = 'g-recaptcha';
    const RESPONSE_FIELD_KEY = 'g-recaptcha-response';
    const SCRIPT_URL = '//www.google.com/recaptcha/api.js';
    const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';
    const FALLBACK_URL = '//www.google.com/recaptcha/api/fallback';

    public $sitekey = null;
    public $secret = null;

    /**
     * @param string $sitekey
     * @param string $secret
     */
    public function __construct($sitekey, $secret)
    {
        $this->sitekey = $sitekey;
        $this->secret = $secret;
    }

    /**
     * @param string $response
     * @return bool
     * @throws \ErrorException
     */
    public function verify($response)
    {
        $data = array(
            'secret' => $this->secret,
            'response' => $response,
        );

        $options = array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
        );

        $curl = curl_init(self::VERIFY_URL);
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        if ( curl_errno($curl) )
        {
            throw new \ErrorException(curl_error($curl));
        }
        curl_close($curl);

        // Response contains "error-codes" and "success" objects
        if ( ($result = json_decode($response)) == null )
        {
            return false;
        }

        return $result->success;
    }

    /**
     * @return string
     */
    public function getHTML()
    {
        return '<div class="' . self::ELEMENT_CLASS_NAME . '" data-sitekey="' . $this->sitekey . '"></div>'
            . '<noscript>'
            . '<div style="width: 302px; height: 352px;">'
            . '<div style="width: 302px; height: 352px; position: relative;">'
            . '<div style="width: 302px; height: 352px; position: absolute;">'
            . '<iframe src="' . self::FALLBACK_URL . '?k=' . $this->sitekey . '" frameborder="0" scrolling="no" style="width: 302px; height:352px; border-style: none;"></iframe>'
            . '</div>'
            . '<div style="width: 250px; height: 80px; position: absolute; border-style: none; bottom: 21px; left: 25px; margin: 0px; padding: 0px; right: 25px;">'
            . '<textarea id="' . self::RESPONSE_FIELD_KEY . '" name="' . self::RESPONSE_FIELD_KEY . '" class="' . self::RESPONSE_FIELD_KEY . '" style="width: 250px; height: 80px; border: 1px solid #c1c1c1; margin: 0px; padding: 0px; resize: none;" value=""></textarea>'
            . '</div>'
            . '</div>'
            . '</div>'
            . '</noscript>';
    }
}
