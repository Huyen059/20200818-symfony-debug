# PHP Test Unit
## Step 1: Installation/configuration
- Terminal, run:
  ```
  bin/phpunit
  ```
  - It will create a folder `.phpunit` inside `/bin` where you can find the executable file.
  With the current installation, the path is:
  ```
  bin/.phpunit/phpunit-7.5-0/phpunit
  ```
- Now you need to configure it:
  - Go to `Settings/Languages & Frameworks/Test Frameworks`
  - Click on `Path to phpunit.phar`
  - Browse the dir, click on `Show hidden files and directories`
  - Then choose the path mentioned above

- Copy the file `phpunit.xml.dist` to `phpunit.xml` (to modify the configurations if needed without changing the  default one in phpunit.xml.dist)

## Step 2: Run test unit
- Right click on `/tests` in the root, choose `New/PHP Test/PHP Unit test`
- The file name has to end with `Test`, for example: `RoomAvailabilityTest`
- Inside the new test class, there is one class:
  ```
  class RoomAvailabilityTest extends TestCase 
  {
    public function testSum()
        {
            $a = 1;
            $b = 2;
            $c = 4;
            self::assertEquals($c, ($a + $b));
        }
  }
  ```
- To make a test, create a public function that begin with `test`, for example `testSum`
- Methods to test: 3 most common ones: `assertEquals`, `assertTrue`, `assertFalse`
- If you configure correctly, you can press the green button next to the function definition to run the test
