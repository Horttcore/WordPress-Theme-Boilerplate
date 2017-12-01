<?php
/**
 * Asset management
 *
 * @package Horttcore\WP_SLUG
 */
namespace Horttcore\WP_SLUG;

class Customizer
{


    /**
     * Options
     *
     * @var array
     */
    protected $options = [];


    /**
     * Panels
     *
     * @var array
     */
    protected $panels = [];


    /**
     * Sections
     *
     * @var array
     */
    protected $sections = [];


    /**
     * Register customizer fields
     *
     * @param array $config Kirki configuration
     * @return void
     */
    public function __construct()
    {
        add_action( 'customize_register', [$this, 'registerPanels'] );
        add_action( 'customize_register', [$this, 'registerSections'] );
        add_filter( 'kirki/controls', [$this, 'registerOptions'] );
    }


    /**
     * Add customizer option
     *
     * @param type var Description
     * @return void
     */
    public function addOption(string $option, string $label, string $section):void
    {
        $this->options[$section][$option] = $label;
    }


    /**
     * Add customizer panel
     *
     * @param string $panelID Panel identifier
     * @param string $panelName Panel name
     * @return void
     */
    public function addPanel(string $panelID, string $panelName):void
    {
        $this->panels[$panelID] = $panelName;
    }


    /**
     * Add customizer section
     *
     * @param type var Description
     * @return void
     */
    public function addSection(string $sectionID, string $sectionName, $panelID):void
    {
        $this->sections[$panelID][$sectionID] = $sectionName;
    }


    /**
     * Register options
     *
     * @param array $controls Controls
     * @return array Controls
     */
    public function registerOptions($controls):array
    {
        foreach ($this->options as $section => $options) :
            $priority = 1;
            foreach ($options as $option => $label) :
                $controls[] = [
                    'type'        => 'text',
                    'settings'    => $option,
                    'label'       => $label,
                    'description' => '',
                    'help'        => '',
                    'section'     => $section,
                    'default'     => '',
                    'priority'    => $priority,
                    'option_type' => 'option'
                ];
                $priority++;
            endforeach;
        endforeach;
        return $controls;
    }


    /**
     * Register customizer panels
     *
     * @return void
     */
    public function registerPanels($customizer):void
    {
        $priority = 3;
        foreach ($this->panels as $panelID => $panelName) :
            $customizer->add_panel( $panelID, array(
                'priority'    => $priority * 10,
                'title'       => $panelName,
            ) );
            $priority++;
        endforeach;
    }


    /**
     * Register customizer sections
     *
     * @return void
     */
    public function registerSections($customizer):void
    {
        foreach ($this->sections as $panel => $sections) :
            $priority = 1;
            foreach ($sections as $sectionID => $sectionName) :
                $customizer->add_section( $sectionID, array(
                    'title'       => $sectionName,
                    'priority'    => 100,
                    'panel'       => $panel,
                    'description' => '',
                ) );
                $priority++;
            endforeach;
        endforeach;
    }
}
