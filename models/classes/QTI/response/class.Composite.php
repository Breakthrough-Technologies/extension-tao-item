<?php

error_reporting(E_ALL);

/**
 * TAO - taoItems/models/classes/QTI/response/class.Composite.php
 *
 * $Id$
 *
 * This file is part of TAO.
 *
 * Automatically generated on 23.01.2012, 18:25:52 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Joel Bout, <joel.bout@tudor.lu>
 * @package taoItems
 * @subpackage models_classes_QTI_response
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * include taoItems_models_classes_QTI_response_ResponseProcessing
 *
 * @author Joel Bout, <joel.bout@tudor.lu>
 */
require_once('taoItems/models/classes/QTI/response/class.ResponseProcessing.php');

/**
 * include
 *
 * @author Joel Bout, <joel.bout@tudor.lu>
 */
require_once('taoItems/models/classes/QTI/response/interactionResponseProcessing/class.InteractionResponseProcessing.php');

/**
 * include taoItems_models_classes_QTI_response_Rule
 *
 * @author Joel Bout, <joel.bout@tudor.lu>
 */
require_once('taoItems/models/classes/QTI/response/interface.Rule.php');

/* user defined includes */
// section 127-0-1-1-786830e4:134f066fb13:-8000:0000000000009010-includes begin
// section 127-0-1-1-786830e4:134f066fb13:-8000:0000000000009010-includes end

/* user defined constants */
// section 127-0-1-1-786830e4:134f066fb13:-8000:0000000000009010-constants begin
// section 127-0-1-1-786830e4:134f066fb13:-8000:0000000000009010-constants end

/**
 * Short description of class taoItems_models_classes_QTI_response_Composite
 *
 * @abstract
 * @access public
 * @author Joel Bout, <joel.bout@tudor.lu>
 * @package taoItems
 * @subpackage models_classes_QTI_response
 */
abstract class taoItems_models_classes_QTI_response_Composite
    extends taoItems_models_classes_QTI_response_ResponseProcessing
        implements taoItems_models_classes_QTI_response_Rule
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd : 

    // --- ATTRIBUTES ---

    /**
     * Short description of attribute components
     *
     * @access protected
     * @var array
     */
    protected $components = array();

    /**
     * Short description of attribute outcomeIdentifier
     *
     * @access protected
     * @var string
     */
    protected $outcomeIdentifier = '';

    // --- OPERATIONS ---

    /**
     * Short description of method getRule
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @return string
     */
    public function getRule()
    {
        $returnValue = (string) '';

        // section 127-0-1-1-3397f61e:12c15e8566c:-8000:0000000000002AFF begin
		foreach ($this->components as $irp) {
        	$returnValue .= $irp->getRule();
        }
		foreach ($this->getCompositionRules() as $rule) {
			$returnValue .= $rule->getRule();
		}
        // section 127-0-1-1-3397f61e:12c15e8566c:-8000:0000000000002AFF end

        return (string) $returnValue;
    }

    /**
     * Short description of method create
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Item item
     * @return taoItems_models_classes_QTI_response_ResponseProcessing
     */
    public static function create( taoItems_models_classes_QTI_Item $item)
    {
        $returnValue = null;

        // section 127-0-1-1-6f11fd4b:1350ab5145f:-8000:0000000000003612 begin
        $returnValue = new taoItems_models_classes_QTI_response_Summation();
        foreach ($item->getInteractions() as $interaction) {
        	$irp = new taoItems_models_classes_QTI_response_interactionResponseProcessing_None($interaction->getResponse()->getIdentifier());
			$returnValue->add($irp);
        }
        $returnValue->ensureOutcomeVariablesExist($item);
        // section 127-0-1-1-6f11fd4b:1350ab5145f:-8000:0000000000003612 end

        return $returnValue;
    }

    /**
     * Short description of method takeOverFrom
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  ResponseProcessing responseProcessing
     * @param  Item item
     * @return taoItems_models_classes_QTI_response_Composite
     */
    public static function takeOverFrom( taoItems_models_classes_QTI_response_ResponseProcessing $responseProcessing,  taoItems_models_classes_QTI_Item $item)
    {
        $returnValue = null;

        // section 127-0-1-1-4c0a0972:134fa47975d:-8000:00000000000035DC begin
        // already good?
        if ($responseProcessing instanceof static) {
        	$returnValue = $responseProcessing;
        }
        // IMS Template
        elseif ($responseProcessing instanceof taoItems_models_classes_QTI_response_Template) {
        	$rp = new taoItems_models_classes_QTI_response_Summation();
        	switch ($responseProcessing->getUri()) {
        		case QTI_RESPONSE_TEMPLATE_MATCH_CORRECT :
        			$irp = new taoItems_models_classes_QTI_response_interactionResponseProcessing_MatchCorrectTemplate('RESPONSE');
        			break;
        		case QTI_RESPONSE_TEMPLATE_MAP_RESPONSE :
        			$irp = new taoItems_models_classes_QTI_response_interactionResponseProcessing_MapResponseTemplate('RESPONSE');
        			break;
        		case QTI_RESPONSE_TEMPLATE_MAP_RESPONSE_POINT :
        			$irp = new taoItems_models_classes_QTI_response_interactionResponseProcessing_MapResponsePointTemplate('RESPONSE');
        			break;
        		default :
        			common_Logger::d('Custom template '.$responseProcessing->getUri().' can not be converted to Composite');
        			throw new taoItems_models_classes_QTI_response_TakeoverFailedException();
        	}
        	$rp->add($irp);
        	$returnValue = $rp;
        }
        // TemplateDriven
        elseif ($responseProcessing instanceof taoItems_models_classes_QTI_response_TemplatesDriven) {
        	$rp = new taoItems_models_classes_QTI_response_Summation();
        	foreach ($responseProcessing->getTemplate() as $identifier => $url) {
	        	switch ($url) {
	        		case QTI_RESPONSE_TEMPLATE_MATCH_CORRECT :
	        			$irp = new taoItems_models_classes_QTI_response_interactionResponseProcessing_MatchCorrectTemplate($identifier);
	        			break;
	        		case QTI_RESPONSE_TEMPLATE_MAP_RESPONSE :
	        			$irp = new taoItems_models_classes_QTI_response_interactionResponseProcessing_MapResponseTemplate($identifier);
	        			break;
	        		// does not exist yet
	        		case QTI_RESPONSE_TEMPLATE_MAP_RESPONSE_POINT :
	        			$irp = new taoItems_models_classes_QTI_response_interactionResponseProcessing_MapResponsePointTemplate($identifier);
	        			break;
	        		default :
	        			common_Logger::w('unknwon template "'.$url.'" in templatesDriven can not be converted to Composite');
	        			throw new taoItems_models_classes_QTI_response_TakeoverFailedException();
	        	}
	        	$rp->add($irp);
        	}
        	$returnValue = $rp;
        }
        
        else {
        	common_Logger::d('Composite ResponseProcessing can not takeover from '.get_class($responseProcessing).' yet');
        	throw new taoItems_models_classes_QTI_response_TakeoverFailedException();
        }
        
	    common_Logger::i('Converted to Composite', array('TAOITEMS', 'QTI'));
        // section 127-0-1-1-4c0a0972:134fa47975d:-8000:00000000000035DC end

        return $returnValue;
    }

    /**
     * Short description of method add
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  InteractionResponseProcessing interactionResponseProcessing
     * @return mixed
     */
    public function add( taoItems_models_classes_QTI_response_interactionResponseProcessing_InteractionResponseProcessing $interactionResponseProcessing)
    {
        // section 127-0-1-1-4c0a0972:134fa47975d:-8000:00000000000035F6 begin
        $this->components[$interactionResponseProcessing->getResponseIdentifier()] = $interactionResponseProcessing;
        // section 127-0-1-1-4c0a0972:134fa47975d:-8000:00000000000035F6 end
    }

    /**
     * Short description of method ensureOutcomeVariablesExist
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Item item
     * @return mixed
     */
    public function ensureOutcomeVariablesExist( taoItems_models_classes_QTI_Item $item)
    {
        // section 127-0-1-1-4c0a0972:134fa47975d:-8000:0000000000003620 begin
        $outcomes = array();
        foreach ($item->getOutcomes() as $outcome) {
        	$outcomes[$outcome->getIdentifier()] = $outcome;
        }
        foreach ($this->components as $component) {
        	if (!in_array($component->getOutcomeIdentifier(), array_keys($outcomes))) {
        		$outcomes[$component->getOutcomeIdentifier()] = $component->generateOutcomeDefinition();
        	}
        }
        if (!isset($outcomes['SCORE']))
			$outcomes['SCORE'] = new taoItems_models_classes_QTI_Outcome('SCORE', array('baseType' => 'integer', 'cardinality' => 'single'));
    	$item->setOutcomes($outcomes);
        // section 127-0-1-1-4c0a0972:134fa47975d:-8000:0000000000003620 end
    }

    /**
     * Short description of method getInteractionResponseProcessing
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  string identifier
     * @return taoItems_models_classes_QTI_response_interactionResponseProcessing_InteractionResponseProcessing
     */
    public function getInteractionResponseProcessing($identifier)
    {
        $returnValue = null;

        // section 127-0-1-1-6f11fd4b:1350ab5145f:-8000:000000000000362E begin
        if (!isset($this->components[$identifier]))
        	throw new common_Exception('No interactionResponseProcessing defined for '.$identifier);
        $returnValue = $this->components[$identifier];
        // section 127-0-1-1-6f11fd4b:1350ab5145f:-8000:000000000000362E end

        return $returnValue;
    }

    /**
     * Short description of method toQTI
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @return string
     */
    public function toQTI()
    {
        $returnValue = (string) '';

        // section 127-0-1-1-4c0a0972:134fa47975d:-8000:0000000000003626 begin
        $returnValue = "<responseProcessing>";
    	foreach ($this->components as $irp) {
        	$returnValue .= $irp->toQTI();
        }
        $returnValue .= $this->getCompositionQTI();
        $returnValue .= "</responseProcessing>";
        // section 127-0-1-1-4c0a0972:134fa47975d:-8000:0000000000003626 end

        return (string) $returnValue;
    }

    /**
     * Short description of method getCompositionRules
     *
     * @abstract
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @return array
     */
    public abstract function getCompositionRules();

    /**
     * Short description of method getCompositionQTI
     *
     * @abstract
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @return string
     */
    public abstract function getCompositionQTI();

} /* end of abstract class taoItems_models_classes_QTI_response_Composite */

?>