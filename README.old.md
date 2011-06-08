phbench is a PHP Benchmark Test. It aims to be a complex solution, beyond simple math operations, for load testing different PHP stacks by using the various functionality of the PHP core. Since it's an extensible architecture, you can write your own tests and plug them into phbench.

v0.2 is the new release, providing the results into a mode detailed procedure. Currently it has just a web interface (unlike the previos version that supported CLI formatted output as well). A CLI version is planned.

The standard distribution tests are:
  * datastructure - Stack / Queue on top of array(). Tests the basic math operations as well.
  * datetime - Basic date/time operations.
  * foreach - foreach() on array / object while executing some math functions.
  * gd - Image creation with the GD library.
  * lookup - Lookup table test (non indexed search, 50% valid entries).
  * pcre - PCRE benchmark (match / replace).
  * prime - Computes if the input is a prime number.
  * sha - Generates sha1, sha256, sha512 hashes by using the hash library.
  * uuid - Type 4 (Random) UUID generation.

It uses just PHP extensions included with the standard PHP distribution, but it avoids the usage of libraries that use external services in order to make the tests to be fair.

It provides the execution time and the memory usage for each test. It also provides the total execution time and the total used memory.

For more details, check the included README file.

The application is built onto the Kohana PHP Framework, http://kohanaframework.org/
