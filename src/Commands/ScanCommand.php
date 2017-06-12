<?php

namespace JansenFelipe\OMR\Commands;

use JansenFelipe\OMR\Maps\MapJson;
use JansenFelipe\OMR\Scanners\ImagickScanner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ScanCommand extends Command
{
    /**
     * Configure method
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('scan')
            ->setDescription('Scan a image file')
            ->addArgument(
                'imageJPG',
                InputArgument::REQUIRED,
                'Image JPG path to be scanned'
            )
            ->addArgument(
                'mapJSON',
                InputArgument::REQUIRED,
                'Path JSON MAP file with the targets'
            )
            ->addOption(
                'debug',
                null,
                InputOption::VALUE_NONE,
                'Generate debug.jpg'
            );
    }

    /**
     * Execute method
     *
     * @param InputInterface $input The input
     * @param OutputInterface $output The output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $imagePath = $input->getArgument('imageJPG');
        $mapJsonPath = $input->getArgument('mapJSON');
        $debug = $input->getOption('debug');

        /*
         * Setup scanner
         */
        $scanner = new ImagickScanner();
        $scanner->setDebug($debug);
        $scanner->setImagePath($imagePath);

        /*
         * Setup map
         */
        $map = MapJson::create($mapJsonPath);

        /*
         * Scan
         */
        $result = $scanner->scan($map, 28);
    }
}
