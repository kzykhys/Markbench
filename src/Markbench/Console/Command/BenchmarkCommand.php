<?php

namespace Markbench\Console\Command;

use Composer\Factory;
use Composer\IO\NullIO;
use Markbench\Exception\TooMuchPackageFoundException;
use Markbench\ProfileInterface;
use Markbench\Result;
use Markbench\Runner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class BenchmarkCommand extends Command
{

    /**
     * @var array
     */
    private $versions = [];

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('benchmark')
            ->setDescription('Run a benchmark with selected profile')
            ->addOption('profile', 'p', InputOption::VALUE_OPTIONAL, 'Name of a profile', 'default')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $runner = new Runner();
        $this->registerDrivers($runner);

        $profiles = $this->getProfiles();
        $profile  = $input->getOption('profile');

        if (!isset($profiles)) {
            $output->writeln('<error>Unknown profile: ' . $profile . '</error>');

            return 1;
        }

        foreach ($runner->getDrivers() as $driver) {
            if (!isset($this->versions[$driver->getName()])) {
                $this->versions[$driver->getName()] = $this->getVersion($driver->getName());
            }
        }

        $output->writeln('Runtime: PHP' . phpversion());
        $output->writeln('Host:    ' . php_uname());

        $this->runProfile($runner, $profiles[$profile], $output);

        return 0;
    }

    /**
     * @param Runner           $runner
     * @param ProfileInterface $profile
     * @param OutputInterface  $output
     */
    protected function runProfile(Runner $runner, ProfileInterface $profile, OutputInterface $output)
    {
        $output->writeln(sprintf('Profile: <info>%s</info>', $profile->getDescription()));
        $output->writeln('Class:   ' . get_class($profile));
        $output->writeln('');

        $results = $runner->run($profile->getContent(), $profile->getLoopCount());

        // order by duration
        uasort($results, function (Result $A, Result $B) {
            if ($A->getDuration() == $B->getDuration()) {
                return 0;
            }

            return $A->getDuration() > $B->getDuration() ? 1 : -1;
        });

        /* @var \Symfony\Component\Console\Helper\TableHelper $table */
        $table = $this->getHelper('table');

        $table->setHeaders(['package', 'version', 'dialect', 'duration (MS)', 'MEM (B)', 'PEAK MEM (B)']);

        foreach ($results as $value) {
            $table->addRow(
                [
                    $value->getName(),
                    $this->versions[$value->getName()],
                    $value->getDialect(),
                    $value->getDuration(),
                    $value->getMemory(),
                    $value->getPeakMemory()
                ]
            );
        }

        $table->render($output);
    }

    /**
     * @return ProfileInterface[]
     */
    protected function getProfiles()
    {
        $profiles = [];
        $finder = Finder::create()
            ->in(__DIR__ . '/../../Profile')
            ->files()
            ->name('*Profile.php');

        foreach ($finder as $file) {
            /* @var \Symfony\Component\Finder\SplFileInfo $file */
            /* @var ProfileInterface $profile */

            $className = str_replace('.php', '', $file->getRelativePathname());
            $fqcn      = 'Markbench\\Profile\\' . $className;
            $profile   = new $fqcn();

            $profiles[$profile->getName()] = $profile;
        }

        return $profiles;
    }

    /**
     * @param Runner $runner
     */
    protected function registerDrivers(Runner $runner)
    {
        $finder = Finder::create()
            ->in(__DIR__ . '/../../Driver')
            ->files()
            ->name('*Driver.php');

        foreach ($finder as $file) {
            /* @var \Symfony\Component\Finder\SplFileInfo $file */

            $className = str_replace('.php', '', $file->getRelativePathname());
            $fqcn      = 'Markbench\\Driver\\' . $className;

            $runner->addDriver(new $fqcn());
        }
    }

    /**
     * @param $package
     * @return string
     * @throws \Markbench\Exception\TooMuchPackageFoundException
     */
    protected function getVersion($package)
    {
        $composer   = Factory::create(new NullIO(), __DIR__.'/../../../../composer.json');
        $repository = $composer->getRepositoryManager()->getLocalRepository();
        $packages   = $repository->findPackages($package);

        if (count($packages) > 1) {
            throw new TooMuchPackageFoundException();
        }

        /* @var \Composer\Package\Package $package */
        $package = $packages[0];

        return $package->getPrettyVersion();
    }

} 