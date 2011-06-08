# phbench documentation

# Requirements

- The official Kohana v3.0.x requirements (phbench v0.2 is built on top of
Kohana 3.0.9 - although it says 3.0.8 - that's an upstream versioning issue).
See the installation procedure which keeps the original Kohana install file.
- gd extension
- hash extension
- json extension
- date extension
- pcre extension

All of the specified extensions are standard PHP extension, part of the official
source distribution, but they may not be enabled for your environment.

# Installation

Upload the phbench directory to the document root of your testing virtual host.
If you would like to host it into another directory, then edit
application/bootstrap.php and change this line: 'base_url'   => '/phbench',

Access phbench from your web browser (eg: http://example.com/phbench). It should
display the Kohana installation test. If everything is OK, remove / rename the
install.php file. Reload the page. The phbench interface should appear. If it
says something about missing PHP extensions, then install the specified PHP
extension as the application requires it.

# Options

You may change some internals of the phbench working. Unless your situation
requires you to change some of the settings, it's recommended to keep the
defaults. The only setting that doesn't affect the actual end result is the gap
setting. Since JavaScript doesn't have sleep support (unless a busy loop is
deployed, which is plain stupid), the tests are fired via the window.setTimeout
method by placing the gap interval between the execution timeouts. If you
execute the test over a slow network, as a consequence of the previous
statements, increase the gap value so the tests won't overlap.

The configuration file is: application/config/phbench.php - the options are
explained by the phbench interface as well.

# Writing your own test

phbench supports a 'drop-in' architecture. You may write your own tests as long
as you obey the application's architecture.

In order to write your own test, create a new class into this directory:
application/classes/phbench. The framework conventions require that the class
name start with Phbench_ so if you wan't to write a 'loop' test for example,
create a loop.php file within the specified directory. Into the loop.php file
declare the Phbench_Loop class. You may extend the Phbench class or not. If you
extend it, you may use the following properties: loops and squares. The loops
contains the number of iterations for a linear scaling test (such as reading the
elements of a vector) or quadratic scaling tests (such as reading the elements
of a matrix or generating a square image).

If you would like to have a custom description into the tests table, declare the
public static property $description, then fill in the details. You MUST define
the description if you don't extend the Phbench class. The description is
populated into the tests table via a reflection method.

In order to plug-in the test into the phbench architecture, create a public
static method named run that calls all your benchmarking code. The rest of the
application takes care of the time / memory benchmarking.

If your tests depend on PHP extensions, is recommended to define a test within
the phbench configuration file.

You may use the provided tests into the standard distribution for examples.

# Extra info

Since phbench is now built on top of Kohana, it uses its Profiling support for
the benchmark results. For the same reason, the Codebench module is enabled by
default, while it's linked into the phbench interface with a slightly modified
frontend. Since I'm a big fan of Codebench, I couldn't leave it out. Besides
platforms, I also benchmark code from time to time.
