# phbench documentation

## About

phbench is a PHP Benchmark Test. It aims to be a complex solution, beyond simple math operations, for load testing different PHP stacks by using the various functionality of the PHP core. Since it's an extensible architecture, you can write your own tests and drop them into phbench.

## Requirements

phbench requires PHP 5.2.3+ and some of the extensions that you can find into a pretty standard installation. The application checks itself for the required dependencies. It notifies you if some of the dependencies are missing or if the runtime is improperly configured. It is built on top of Kohana for PHP framework.

## Installation

 * Download the phbench.
 * Upload the phbench directory to the document root of your testing virtual host. You must point your browser to http://example.com/phbench/ in order to start the application. If you would like to change the subdirectory name from phbench to something else, edit the base_url variable from phbench/application/bootstrap.php.

If the PHP dependencies are installed and properly configured, you may start to use the application.

## The tests

 * datastructure - Stack / Queue on top of array(). Tests the basic math operations as well.
 * datetime - Basic date/time operations.
 * foreach - foreach() on array / object while executing some math functions.
 * gd - Image creation with the GD library.
 * lookup - Lookup table test (non indexed search, 50% valid entries).
 * pcre - PCRE benchmark (match / replace).
 * prime - Computes if the input is a prime number.
 * sha - Generates sha1, sha256, sha512 hashes by using the hash library.
 * uuid - Type 4 (Random) UUID generation.

It uses just PHP extensions included with the standard PHP distribution, but it avoids the usage of libraries that do Inter Process Communication (such as MySQL). You may write such tests, but you have to make sure that the testing environment would be fair.

## The results

It provides the total execution time for each test, and for all tests. It also provides the standard deviation of the results (theory: http://en.wikipedia.org/wiki/Standard_deviation).

## Options

You may change some internals of the phbench working. Unless your situation requires you to change some of the settings, it's recommended to keep the defaults. The only setting that doesn't affect the actual end result is the gap setting. Since JavaScript doesn't have sleep support (unless a busy loop is deployed, which is plain stupid), the tests are fired via the window.setTimeout method by placing the gap interval between the execution timeouts. If you execute the test over a slow network, as a consequence of the previous statements, increase the gap value so the tests won't overlap.

The configuration file is: application/config/phbench.php - the options are explained by the phbench interface as well.

## Writing your own test

phbench supports a 'drop-in' architecture. You may write your own tests as long as you obey the application's architecture.

In order to write your own test, create a new class into this directory: application/classes/phbench. The framework conventions require that the class name start with Phbench_ so if you wan't to write a 'loop' test for example, create a loop.php file within the specified directory. Into the loop.php file declare the Phbench_Loop class. You may extend the Phbench class or not. If you extend it, you may use the following properties: loops and squares. The loops contains the number of iterations for a linear scaling test (such as reading the elements of a vector) or quadratic scaling tests (such as reading the elements of a matrix or generating a square image).

If you would like to have a custom description into the tests table, declare the public static property $description, then fill in the details. You MUST define the description if you don't extend the Phbench class. The description is populated into the tests table via a reflection method.

In order to plug-in the test into the phbench architecture, create a public static method named run that calls all your benchmarking code. The rest of the application takes care of the time / memory benchmarking.

If your tests depend on PHP extensions, is recommended to define a test within the phbench configuration file.

You may use the provided tests into the standard distribution for examples.

## Extra info

Since phbench is now built on top of Kohana, it uses its Profiling support for the benchmark results. For the same reason, the Codebench module is enabled by default, while it's linked into the phbench interface with a slightly modified frontend. Since I'm a big fan of Codebench, I couldn't leave it out. Besides platforms, I also benchmark code from time to time.
