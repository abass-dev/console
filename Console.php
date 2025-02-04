<?php
/*
 * This file is part of the Nigatedev framework package.
 *
 * (c) Abass Ben Cheik <abass@abassdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Nigatedev\Framework\Console;

use Nigatedev\Framework\Console\Exception\InvalidArgumentException;
use Nigatedev\FrameworkBundle\Application\Configuration;
use Nigatedev\Framework\Console\Maker\Make;
use Nigatedev\Framework\Console\Colors;

/**
 * Entry point for the console application
 *
 * @author Abass Ben Cheik <abass@abassdev.com>
 */
final class Console
{
    public function __construct($commands)
    {
        $config = Configuration::getAppConfig();

        // Handling empty command, redirect to helper
        if (!isset($commands[1])) {
            (new Make(["help" => "default"], []));
        } elseif (preg_match("/(^m:c$)|(^make:c$)|(^make:controller$)|(^m:controller$)/", $commands[1])) {
            (new Make(
                ["controller" => $commands],
                $config["controller"]
            ));
        } elseif (preg_match("/(^m:e$)|(^make:e$)|(^make:entity$)|(^m:entity$)/", $commands[1])) {
            (new Make(
                ["entity"  => $commands],
                $config["entity"]
            ));
        } elseif (preg_match("/(^run:dev$)/", $commands[1])) {
            (new Make(
                ["server"  => $commands],
                $config["server"]
            ));
        } else {
            die(Colors::danger("Command unknown\n"));
        }
    }
}
