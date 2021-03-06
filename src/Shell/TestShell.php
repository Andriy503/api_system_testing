<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Mailer\Email;

/**
 * Test shell command.
 */
class TestShell extends Shell
{

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $email = new Email();

        // text format and load text file and add variables
            // $email
            //     ->setTo('baumketner1@ukr.net')
            //     ->setSubject('Test Email')
            //     ->setEmailFormat('text')
            //     // ->addBcc('super.andriy503@ukr.net')
            //     ->setViewVars([
            //         'name' => 'Alex'
            //     ])
            //     ->viewBuilder()
            //         ->setTemplate('testing');

        // load html file
        $email
            ->setTo('baumketner1@ukr.net')
            ->setSubject('Test Email format 2')
            ->setEmailFormat('html')
            // ->addBcc('super.andriy503@ukr.net')
            ->setViewVars([
                'name' => 'Alex'
            ])
            ->viewBuilder()
                ->setTemplate('testing2');

        $email->send();
    }
}
