<?php

namespace Markbench\Console\Command;

use Composer\Factory;
use Composer\IO\NullIO;
use Markbench\Exception\TooMuchPackageFoundException;
use Markbench\ProfileInterface;
use Markbench\Result;
use Markbench\Runner;
use PHPGit\Git;
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
     * @var \Markbench\DriverInterface[]
     */
    private $drivers = [];

    /**
     * {@inheritdoc}
     */
    public function __construct($name = null)
    {
        $finder = Finder::create()
            ->in(__DIR__ . '/../../Driver')
            ->files()
            ->name('*Driver.php');

        foreach ($finder as $file) {
            /* @var \Symfony\Component\Finder\SplFileInfo $file */
            $className = str_replace('.php', '', $file->getRelativePathname());
            $fqcn      = 'Markbench\\Driver\\' . $className;
            $driver    = new $fqcn();
            $name      = $driver->getName();

            if ($dialect = $driver->getDialect()) {
                $name .= ':' . $dialect;
            }

            $this->drivers[$name] = $driver;
        }

        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('benchmark')
            ->setDescription('Run a benchmark with selected parser and profile')
            ->addOption('parser', '', InputOption::VALUE_REQUIRED, 'Name of a parser. Available: ' . implode(', ', array_keys($this->drivers)))
            ->addOption('profile', 'p', InputOption::VALUE_OPTIONAL, 'Name of a profile.', 'default')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $runner = new Runner();
        $this->registerDrivers($runner, $input->getOption('parser'));

        $profiles = $this->getProfiles();
        $profile  = $input->getOption('profile');

        if (!isset($profiles[$profile])) {
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
     * @param string $parserName Name of parser to include drivers for
     */
    protected function registerDrivers(Runner $runner, $parserName)
    {
        foreach ($this->drivers as $driver) {
            $matchParser = (!$parserName || in_array($parserName, [
                $driver->getName(),
                $driver->getName().':'.$driver->getDialect()
            ]));

            if ($matchParser && $driver->checkRequirements()) {
                $runner->addDriver($driver);
            }
        }
    }

    /**
     * @param $package
     *
     * @throws \RuntimeException
     * @throws \Markbench\Exception\TooMuchPackageFoundException
     * @return string
     */
    protected function getVersion($package)
    {
        $json_path = '';
        $json_paths = [
            getcwd() . '/composer.json',
            __DIR__.'/../../../../composer.json',
            __DIR__.'/../../../../../../composer.json',
        ];

        foreach ($json_paths as $path) {
            if (file_exists($path)) {
                $json_path = $path;
                break;
            }
        }

        if (!$json_path) {
            throw new \RuntimeException('Unable to find composer.json');
        }

        $composer   = Factory::create(new NullIO(), $json_path);
        $repository = $composer->getRepositoryManager()->getLocalRepository();
        /* @var \Composer\Package\Package[] $packages */
        $packages   = $repository->findPackages($package);

        if (($count = count($packages)) > 1) {
            throw new TooMuchPackageFoundException();
        } elseif ($count == 0) {
            try {
                // get extension ver
                $ext = new \ReflectionExtension($package);
                return $ext->getVersion();
            } catch (Exception $e) {
                $git = new Git();
                $git->setRepository(dirname($json_path));

                return $git->describe->tags();
            }
        } else {
            return $packages[0]->getPrettyVersion();
        }
    }

}
