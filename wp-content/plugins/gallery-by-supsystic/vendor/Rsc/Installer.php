<?php


class Rsc_Installer
{
    /**
     * @var Rsc_Installer_Parser
     */
    private $parser;

    /**
     * @param Rsc_Installer_Parser $parser
     */
    public function __construct(Rsc_Installer_Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Run installation
     *
     * @param bool $triggerError If set to true then method will be trigger fatal error if installation is failed
     * @param int $error
     */
    public function install($triggerError = true, $error = 256)
    {
        try {
            $queries = $this->parser->getQueries();

            foreach ($queries as $query) {
                $this->delta($query);
            }

        } catch (Exception $e) {
            trigger_error(
                sprintf(__('Failed to install the plugin: %s', 'rsc-framework'), $e->getMessage()),
                (int) $error
            );
        }
    }

    protected function delta($query)
    {
        if (!function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        return dbDelta($query);
    }
} 