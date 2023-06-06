<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\ModifiedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\ProductTrimsRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Table]
#[ORM\Entity]
class ProductDetails
{
    use EntityIdTrait;
    use CreatedAtTrait;
    use ModifiedAtTrait;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $vin = '';

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $product_id;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $year = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $make = null;
    
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $model = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $suggested_vin = '';
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $possible_values = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $vehicle_descriptor = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $destination_market = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $manufacturer_name = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $plant_city = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $series = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $vehicle_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $plant_country = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $plant_company_name = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $plant_state = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $trim2 = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $trim = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $series2 = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = '';

    #[ORM\Column(type: 'decimal', nullable: true)]
    private ?DecimalType $base_price;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $non_land_use = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $body_class = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $doors = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $windows = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $wheel_base_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $track_width_inches = 'null';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $gross_vehicle_weight_rating_from = '';
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bed_length_inches = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $curb_weight_pounds = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $wheel_base_inches_from = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $wheel_base_inches_to = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $gross_combination_weight_rating_from = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $gross_combination_weight_rating_to = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $gross_vehicle_weight_rating_to = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bed_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cab_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $trailer_type_connection = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $trailer_body_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $trailer_length_feet = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $other_trailer_info = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $number_of_wheels = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $wheel_size_front_inches = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $wheel_size_rear_inches = '';
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $entertainment_system = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $steering_location = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $number_of_seats = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $number_of_seat_rows = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $transmission_style = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $transmission_speeds = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $drive_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $axles = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $axle_configuration = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $brake_system_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $brake_system_description = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $other_battery_info = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $battery_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $number_of_battery_cells_per_module = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $battery_current_amps_from = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $battery_voltage_volts_from = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $battery_energy_kwh_from = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ev_drive_unit = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $battery_current_amps_to = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $battery_voltage_volts_to = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $battery_energy_kwh_to = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $number_of_battery_modules_per_pack = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $number_of_battery_packs_per_vehicle = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $charger_level = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $charger_power_kw = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $engine_number_of_cylinders = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $displacement_cc = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $displacement_ci = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $displacement_l = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $engine_stroke_cycles = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $engine_model = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $engine_power_kw = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $fuel_type_primary = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $valve_train_design = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $engine_configuration = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $fuel_type_secondary = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $fuel_delivery_fuel_injection_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $engine_brake_hp_from = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cooling_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $engine_brake_hp_to = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $electrification_level = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $other_engine_info = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $turbo = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $top_speed_mph = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $engine_manufacturer = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $pretensioner = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $seat_belt_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $other_restraint_system_info = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $curtain_air_bag_locations = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $seat_cushion_air_bag_locations = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $front_air_bag_locations = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $knee_air_bag_locations = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $side_air_bag_locations = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $anti_lock_braking_system_abs = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $electronic_stability_control_esc = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $traction_control = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $tire_pressure_monitoring_system_tpms_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $active_safety_system_note = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $auto_reverse_system_for_windows_and_sunroofs = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only = '';
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $event_data_recorder_edr = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $keyless_ignition = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $sae_automation_level_from = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $sae_automation_level_to = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ncsa_body_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ncsa_make = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ncsa_model = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ncsa_note = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $adaptive_cruise_control_acc = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $crash_imminent_braking_cib = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $blind_spot_warning_bsw = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $forward_collision_warning_fcw = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lane_departure_warning_ldw = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lane_keeping_assistance_lka = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $backup_camera = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $parking_assist = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bus_length_feet = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bus_floor_configuration_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bus_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $other_bus_info = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $custom_motorcycle_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motorcycle_suspension_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motorcycle_chassis_type = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $other_motorcycle_info = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dynamic_brake_support_dbs = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $pedestrian_automatic_emergency_braking_paeb = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $automatic_and_advanced_crash_notification_aacn = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $daytime_running_light_drl = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $headlamp_light_source = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $semiautomatic_headlamp_beam_switching = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $adaptive_driving_beam_adb = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $rear_cross_traffic_alert = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $rear_automatic_emergency_braking = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $blind_spot_intervention_bsi = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lane_centering_assistance = '';

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?string $vin_response = '';

    #[ORM\OneToOne(inversedBy: 'product_details', targetEntity: Product::class, cascade: ['persist', 'remove'])]
    // #[JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    public function __construct()
    {
    }

    public function getPossibleValues()
    {
        return $this->possible_values;
    }

    public function setPossibleValues( $possible_values): self
    {
        $this->possible_values = $possible_values;

        return $this;
    }

    public function getSuggestedVin()
    {
        return $this->suggested_vin;
    }

    public function setSuggestedVin( $suggested_vin): self
    {
        $this->suggested_vin = $suggested_vin;

        return $this;
    }

    public function getVin()
    {
        return $this->vin;
    }

    public function setVin( $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    public function getVehicleDescriptor()
    {
        return $this->vehicle_descriptor;
    }

    public function setVehicleDescriptor( $vehicle_descriptor): self
    {
        $this->vehicle_descriptor = $vehicle_descriptor;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    public function getTrackWidthInches()
    {
        return $this->track_width_inches;
    }
    public function setTrackWidthInches($track_width_inches)
    {
        $this->track_width_inches = $track_width_inches;
        return $this;
    }
    public function getGrossVehicleWeightRatingFrom()
    {
    return $this->gross_vehicle_weight_rating_from;
    }
    public function setGrossVehicleWeightRatingFrom($gross_vehicle_weight_rating_from)
    {
    $this->gross_vehicle_weight_rating_from = $gross_vehicle_weight_rating_from;
    return $this;
    }
    public function getBedLengthInches()
    {
    return $this->bed_length_inches;
    }
    public function setBedLengthInches($bed_length_inches)
    {
    $this->bed_length_inches = $bed_length_inches;
    return $this;
    }
    public function getCurbWeightPounds()
    {
    return $this->curb_weight_pounds;
    }
    public function setCurbWeightPounds($curb_weight_pounds)
    {
    $this->curb_weight_pounds = $curb_weight_pounds;
    return $this;
    }
    public function getWheelBaseInchesFrom()
    {
    return $this->wheel_base_inches_from;
    }
    public function setWheelBaseInchesFrom($wheel_base_inches_from)
    {
    $this->wheel_base_inches_from = $wheel_base_inches_from;
    return $this;
    }
    public function getWheelBaseInchesTo()
    {
    return $this->wheel_base_inches_to;
    }
    public function setWheelBaseInchesTo( $wheel_base_inches_to)
    {
    $this->wheel_base_inches_to = $wheel_base_inches_to;
    return $this;
    }
    public function getGrossCombinationWeightRatingFrom()
    {
    return $this->gross_combination_weight_rating_from;
    }
    public function setGrossCombinationWeightRatingFrom( $gross_combination_weight_rating_from)
    {
    $this->gross_combination_weight_rating_from = $gross_combination_weight_rating_from;
    return $this;
    }
    public function getGrossCombinationWeightRatingTo()
    {
    return $this->gross_combination_weight_rating_to;
    }
    public function setGrossCombinationWeightRatingTo( $gross_combination_weight_rating_to)
    {
    $this->gross_combination_weight_rating_to = $gross_combination_weight_rating_to;
    return $this;
    }
    public function getGrossVehicleWeightRatingTo()
    {
    return $this->gross_vehicle_weight_rating_to;
    }
    public function setGrossVehicleWeightRatingTo( $gross_vehicle_weight_rating_to)
    {
    $this->gross_vehicle_weight_rating_to = $gross_vehicle_weight_rating_to;
    return $this;
    }
    public function getBedType()
    {
    return $this->bed_type;
    }
    public function setBedType( $bed_type)
    {
    $this->bed_type = $bed_type;
    return $this;
    }
    public function getCabType()
    {
    return $this->cab_type;
    }
    public function setCabType( $cab_type)
    {
    $this->cab_type = $cab_type;
    return $this;
    }
    public function getTrailerTypeConnection()
    {
    return $this->trailer_type_connection;
    }
    public function setTrailerTypeConnection( $trailer_type_connection)
    {
    $this->trailer_type_connection = $trailer_type_connection;
    return $this;
    }
    public function getTrailerBodyType()
    {
    return $this->trailer_body_type;
    }
    public function setTrailerBodyType( $trailer_body_type)
    {
    $this->trailer_body_type = $trailer_body_type;
    return $this;
    }
    public function getTrailerLengthFeet()
    {
    return $this->trailer_length_feet;
    }
    public function setTrailerLengthFeet( $trailer_length_feet)
    {
    $this->trailer_length_feet = $trailer_length_feet;
    return $this;
    }
    public function getOtherTrailerInfo()
    {
    return $this->other_trailer_info;
    }
    public function setOtherTrailerInfo( $other_trailer_info)
    {
    $this->other_trailer_info = $other_trailer_info;
    return $this;
    }
    public function getNumberOfWheels()
    {
    return $this->number_of_wheels;
    }
    public function setNumberOfWheels( $number_of_wheels)
    {
    $this->number_of_wheels = $number_of_wheels;
    return $this;
    }
    public function getWheelSizeFrontInches()
    {
    return $this->wheel_size_front_inches;
    }
    public function setWheelSizeFrontInches( $wheel_size_front_inches)
    {
    $this->wheel_size_front_inches = $wheel_size_front_inches;
    return $this;
    }
    public function getWheelSizeRearInches()
    {
    return $this->wheel_size_rear_inches;
    }
    public function setWheelSizeRearInches( $wheel_size_rear_inches)
    {
    $this->wheel_size_rear_inches = $wheel_size_rear_inches;
    return $this;
    }
    public function getEntertainmentSystem()
    {
    return $this->entertainment_system;
    }
    public function setEntertainmentSystem( $entertainment_system)
    {
    $this->entertainment_system = $entertainment_system;
    return $this;
    }
    public function getSteeringLocation()
    {
    return $this->steering_location;
    }
    public function setSteeringLocation( $steering_location)
    {
    $this->steering_location = $steering_location;
    return $this;
    }
    public function getNumberOfSeats()
    {
    return $this->number_of_seats;
    }
    public function setNumberOfSeats( $number_of_seats)
    {
    $this->number_of_seats = $number_of_seats;
    return $this;
    }
    public function getNumberOfSeatRows()
    {
    return $this->number_of_seat_rows;
    }
    public function setNumberOfSeatRows( $number_of_seat_rows)
    {
    $this->number_of_seat_rows = $number_of_seat_rows;
    return $this;
    }
    public function getTransmissionStyle()
    {
    return $this->transmission_style;
    }
    public function setTransmissionStyle( $transmission_style)
    {
    $this->transmission_style = $transmission_style;
    return $this;
    }
    public function getTransmissionSpeeds()
    {
    return $this->transmission_speeds;
    }
    public function setTransmissionSpeeds( $transmission_speeds)
    {
    $this->transmission_speeds = $transmission_speeds;
    return $this;
    }
    public function getDriveType()
    {
    return $this->drive_type;
    }
    public function setDriveType( $drive_type)
    {
    $this->drive_type = $drive_type;
    return $this;
    }
    public function getAxles()
    {
    return $this->axles;
    }
    public function setAxles( $axles)
    {
    $this->axles = $axles;
    return $this;
    }
    public function getAxleConfiguration()
    {
    return $this->axle_configuration;
    }
    public function setAxleConfiguration( $axle_configuration)
    {
    $this->axle_configuration = $axle_configuration;
    return $this;
    }
    public function getBrakeSystemType()
    {
    return $this->brake_system_type;
    }
    public function setBrakeSystemType( $brake_system_type)
    {
    $this->brake_system_type = $brake_system_type;
    return $this;
    }
    public function getBrakeSystemDescription()
    {
    return $this->brake_system_description;
    }
    public function setBrakeSystemDescription( $brake_system_description)
    {
    $this->brake_system_description = $brake_system_description;
    return $this;
    }
    public function getOtherBatteryInfo()
    {
    return $this->other_battery_info;
    }
    public function setOtherBatteryInfo( $other_battery_info)
    {
    $this->other_battery_info = $other_battery_info;
    return $this;
    }
    public function getBatteryType()
    {
    return $this->battery_type;
    }
    public function setBatteryType( $battery_type)
    {
    $this->battery_type = $battery_type;
    return $this;
    }
    public function getNumberOfBatteryCellsPerModule()
    {
    return $this->number_of_battery_cells_per_module;
    }
    public function setNumberOfBatteryCellsPerModule( $number_of_battery_cells_per_module)
    {
    $this->number_of_battery_cells_per_module = $number_of_battery_cells_per_module;
    return $this;
    }
    public function getBatteryCurrentAmpsFrom()
    {
    return $this->battery_current_amps_from;
    }
    public function setBatteryCurrentAmpsFrom( $battery_current_amps_from)
    {
    $this->battery_current_amps_from = $battery_current_amps_from;
    return $this;
    }
    public function getBatteryVoltageVoltsFrom()
    {
    return $this->battery_voltage_volts_from;
    }
    public function setBatteryVoltageVoltsFrom( $battery_voltage_volts_from)
    {
    $this->battery_voltage_volts_from = $battery_voltage_volts_from;
    return $this;
    }
    public function getBatteryEnergyKwhFrom()
    {
    return $this->battery_energy_kwh_from;
    }
    public function setBatteryEnergyKwhFrom( $battery_energy_kwh_from)
    {
    $this->battery_energy_kwh_from = $battery_energy_kwh_from;
    return $this;
    }
    public function getEvDriveUnit()
    {
    return $this->ev_drive_unit;
    }
    public function setEvDriveUnit( $ev_drive_unit)
    {
    $this->ev_drive_unit = $ev_drive_unit;
    return $this;
    }
    public function getBatteryCurrentAmpsTo()
    {
    return $this->battery_current_amps_to;
    }
    public function setBatteryCurrentAmpsTo( $battery_current_amps_to)
    {
    $this->battery_current_amps_to = $battery_current_amps_to;
    return $this;
    }
    public function getBatteryVoltageVoltsTo()
    {
    return $this->battery_voltage_volts_to;
    }
    public function setBatteryVoltageVoltsTo( $battery_voltage_volts_to)
    {
    $this->battery_voltage_volts_to = $battery_voltage_volts_to;
    return $this;
    }
    public function getBatteryEnergyKwhTo()
    {
    return $this->battery_energy_kwh_to;
    }
    public function setBatteryEnergyKwhTo( $battery_energy_kwh_to)
    {
    $this->battery_energy_kwh_to = $battery_energy_kwh_to;
    return $this;
    }
    public function getNumberOfBatteryModulesPerPack()
    {
    return $this->number_of_battery_modules_per_pack;
    }
    public function setNumberOfBatteryModulesPerPack( $number_of_battery_modules_per_pack)
    {
    $this->number_of_battery_modules_per_pack = $number_of_battery_modules_per_pack;
    return $this;
    }
    public function getNumberOfBatteryPacksPerVehicle()
    {
    return $this->number_of_battery_packs_per_vehicle;
    }
    public function setNumberOfBatteryPacksPerVehicle( $number_of_battery_packs_per_vehicle)
    {
    $this->number_of_battery_packs_per_vehicle = $number_of_battery_packs_per_vehicle;
    return $this;
    }
    public function getChargerLevel()
    {
    return $this->charger_level;
    }
    public function setChargerLevel( $charger_level)
    {
    $this->charger_level = $charger_level;
    return $this;
    }
    public function getChargerPowerKw()
    {
    return $this->charger_power_kw;
    }
    public function setChargerPowerKw( $charger_power_kw)
    {
    $this->charger_power_kw = $charger_power_kw;
    return $this;
    }
    public function getEngineNumberOfCylinders()
    {
    return $this->engine_number_of_cylinders;
    }
    public function setEngineNumberOfCylinders( $engine_number_of_cylinders)
    {
    $this->engine_number_of_cylinders = $engine_number_of_cylinders;
    return $this;
    }
    public function getDisplacementCc()
    {
    return $this->displacement_cc;
    }
    public function setDisplacementCc( $displacement_cc)
    {
    $this->displacement_cc = $displacement_cc;
    return $this;
    }
    public function getDisplacementCi()
    {
    return $this->displacement_ci;
    }
    public function setDisplacementCi( $displacement_ci)
    {
    $this->displacement_ci = $displacement_ci;
    return $this;
    }
    public function getDisplacementL()
    {
    return $this->displacement_l;
    }
    public function setDisplacementL( $displacement_l)
    {
    $this->displacement_l = $displacement_l;
    return $this;
    }
    public function getEngineStrokeCycles()
    {
    return $this->engine_stroke_cycles;
    }
    public function setEngineStrokeCycles( $engine_stroke_cycles)
    {
    $this->engine_stroke_cycles = $engine_stroke_cycles;
    return $this;
    }
    public function getEngineModel()
    {
    return $this->engine_model;
    }
    public function setEngineModel( $engine_model)
    {
    $this->engine_model = $engine_model;
    return $this;
    }
    public function getEnginePowerKw()
    {
    return $this->engine_power_kw;
    }
    public function setEnginePowerKw( $engine_power_kw)
    {
    $this->engine_power_kw = $engine_power_kw;
    return $this;
    }
    public function getFuelTypePrimary()
    {
    return $this->fuel_type_primary;
    }
    public function setFuelTypePrimary( $fuel_type_primary)
    {
    $this->fuel_type_primary = $fuel_type_primary;
    return $this;
    }
    public function getValveTrainDesign()
    {
    return $this->valve_train_design;
    }
    public function setValveTrainDesign( $valve_train_design)
    {
    $this->valve_train_design = $valve_train_design;
    return $this;
    }
    public function getEngineConfiguration()
    {
    return $this->engine_configuration;
    }
    public function setEngineConfiguration( $engine_configuration)
    {
    $this->engine_configuration = $engine_configuration;
    return $this;
    }
    public function getFuelTypeSecondary()
    {
    return $this->fuel_type_secondary;
    }
    public function setFuelTypeSecondary( $fuel_type_secondary)
    {
    $this->fuel_type_secondary = $fuel_type_secondary;
    return $this;
    }
    public function getFuelDeliveryFuelInjectionType()
    {
    return $this->fuel_delivery_fuel_injection_type;
    }
    public function setFuelDeliveryFuelInjectionType( $fuel_delivery_fuel_injection_type)
    {
    $this->fuel_delivery_fuel_injection_type = $fuel_delivery_fuel_injection_type;
    return $this;
    }
    public function getEngineBrakeHpFrom()
    {
    return $this->engine_brake_hp_from;
    }
    public function setEngineBrakeHpFrom( $engine_brake_hp_from)
    {
    $this->engine_brake_hp_from = $engine_brake_hp_from;
    return $this;
    }
    public function getCoolingType()
    {
    return $this->cooling_type;
    }
    public function setCoolingType( $cooling_type)
    {
    $this->cooling_type = $cooling_type;
    return $this;
    }
    public function getEngineBrakeHpTo()
    {
    return $this->engine_brake_hp_to;
    }
    public function setEngineBrakeHpTo( $engine_brake_hp_to)
    {
    $this->engine_brake_hp_to = $engine_brake_hp_to;
    return $this;
    }
    public function getElectrificationLevel()
    {
    return $this->electrification_level;
    }
    public function setElectrificationLevel( $electrification_level)
    {
    $this->electrification_level = $electrification_level;
    return $this;
    }
    public function getOtherEngineInfo()
    {
    return $this->other_engine_info;
    }
    public function setOtherEngineInfo( $other_engine_info)
    {
    $this->other_engine_info = $other_engine_info;
    return $this;
    }
    public function getTurbo()
    {
    return $this->turbo;
    }
    public function setTurbo( $turbo)
    {
    $this->turbo = $turbo;
    return $this;
    }
    public function getTopSpeedMph()
    {
    return $this->top_speed_mph;
    }
    public function setTopSpeedMph( $top_speed_mph)
    {
    $this->top_speed_mph = $top_speed_mph;
    return $this;
    }
    public function getEngineManufacturer()
    {
    return $this->engine_manufacturer;
    }
    public function setEngineManufacturer( $engine_manufacturer)
    {
    $this->engine_manufacturer = $engine_manufacturer;
    return $this;
    }
    public function getPretensioner()
    {
    return $this->pretensioner;
    }
    public function setPretensioner( $pretensioner)
    {
    $this->pretensioner = $pretensioner;
    return $this;
    }
    public function getSeatBeltType()
    {
    return $this->seat_belt_type;
    }
    public function setSeatBeltType( $seat_belt_type)
    {
    $this->seat_belt_type = $seat_belt_type;
    return $this;
    }
    public function getOtherRestraintSystemInfo()
    {
    return $this->other_restraint_system_info;
    }
    public function setOtherRestraintSystemInfo( $other_restraint_system_info)
    {
    $this->other_restraint_system_info = $other_restraint_system_info;
    return $this;
    }
    public function getCurtainAirBagLocations()
    {
    return $this->curtain_air_bag_locations;
    }
    public function setCurtainAirBagLocations( $curtain_air_bag_locations)
    {
    $this->curtain_air_bag_locations = $curtain_air_bag_locations;
    return $this;
    }
    public function getSeatCushionAirBagLocations()
    {
    return $this->seat_cushion_air_bag_locations;
    }
    public function setSeatCushionAirBagLocations( $seat_cushion_air_bag_locations)
    {
    $this->seat_cushion_air_bag_locations = $seat_cushion_air_bag_locations;
    return $this;
    }
    public function getFrontAirBagLocations()
    {
    return $this->front_air_bag_locations;
    }
    public function setFrontAirBagLocations( $front_air_bag_locations)
    {
    $this->front_air_bag_locations = $front_air_bag_locations;
    return $this;
    }
    public function getKneeAirBagLocations()
    {
    return $this->knee_air_bag_locations;
    }
    public function setKneeAirBagLocations( $knee_air_bag_locations)
    {
    $this->knee_air_bag_locations = $knee_air_bag_locations;
    return $this;
    }
    public function getSideAirBagLocations()
    {
    return $this->side_air_bag_locations;
    }
    public function setSideAirBagLocations( $side_air_bag_locations)
    {
    $this->side_air_bag_locations = $side_air_bag_locations;
    return $this;
    }
    public function getAntiLockBrakingSystemAbs()
    {
    return $this->anti_lock_braking_system_abs;
    }
    public function setAntiLockBrakingSystemAbs( $anti_lock_braking_system_abs)
    {
    $this->anti_lock_braking_system_abs = $anti_lock_braking_system_abs;
    return $this;
    }
    public function getElectronicStabilityControlEsc()
    {
    return $this->electronic_stability_control_esc;
    }
    public function setElectronicStabilityControlEsc( $electronic_stability_control_esc)
    {
    $this->electronic_stability_control_esc = $electronic_stability_control_esc;
    return $this;
    }
    public function getTractionControl()
    {
    return $this->traction_control;
    }
    public function setTractionControl( $traction_control)
    {
    $this->traction_control = $traction_control;
    return $this;
    }
    public function getTirePressureMonitoringSystemTpmsType()
    {
    return $this->tire_pressure_monitoring_system_tpms_type;
    }
    public function setTirePressureMonitoringSystemTpmsType( $tire_pressure_monitoring_system_tpms_type)
    {
    $this->tire_pressure_monitoring_system_tpms_type = $tire_pressure_monitoring_system_tpms_type;
    return $this;
    }
    public function getActiveSafetySystemNote()
    {
    return $this->active_safety_system_note;
    }
    public function setActiveSafetySystemNote( $active_safety_system_note)
    {
    $this->active_safety_system_note = $active_safety_system_note;
    return $this;
    }
    public function getAutoReverseSystemForWindowsAndSunroofs()
    {
    return $this->auto_reverse_system_for_windows_and_sunroofs;
    }
    public function setAutoReverseSystemForWindowsAndSunroofs( $auto_reverse_system_for_windows_and_sunroofs)
    {
    $this->auto_reverse_system_for_windows_and_sunroofs = $auto_reverse_system_for_windows_and_sunroofs;
    return $this;
    }
    public function getAutomaticPedestrianAlertingSoundForHybridAndEvOnly()
    {
    return $this->automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only;
    }
    public function setAutomaticPedestrianAlertingSoundForHybridAndEvOnly( $automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only)
    {
    $this->automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only = $automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only;
    return $this;
    }
    public function getEventDataRecorderEdr()
    {
    return $this->event_data_recorder_edr;
    }
    public function setEventDataRecorderEdr( $event_data_recorder_edr)
    {
    $this->event_data_recorder_edr = $event_data_recorder_edr;
    return $this;
    }
    public function getKeylessIgnition()
    {
    return $this->keyless_ignition;
    }
    public function setKeylessIgnition( $keyless_ignition)
    {
    $this->keyless_ignition = $keyless_ignition;
    return $this;
    }
    public function getSaeAutomationLevelFrom()
    {
    return $this->sae_automation_level_from;
    }
    public function setSaeAutomationLevelFrom( $sae_automation_level_from)
    {
    $this->sae_automation_level_from = $sae_automation_level_from;
    return $this;
    }
    public function getSaeAutomationLevelTo()
    {
    return $this->sae_automation_level_to;
    }
    public function setSaeAutomationLevelTo( $sae_automation_level_to)
    {
    $this->sae_automation_level_to = $sae_automation_level_to;
    return $this;
    }
    public function getNcsaBodyType()
    {
    return $this->ncsa_body_type;
    }
    public function setNcsaBodyType( $ncsa_body_type)
    {
    $this->ncsa_body_type = $ncsa_body_type;
    return $this;
    }
    public function getNcsaMake()
    {
    return $this->ncsa_make;
    }
    public function setNcsaMake( $ncsa_make)
    {
    $this->ncsa_make = $ncsa_make;
    return $this;
    }
    public function getNcsaModel()
    {
    return $this->ncsa_model;
    }
    public function setNcsaModel( $ncsa_model)
    {
    $this->ncsa_model = $ncsa_model;
    return $this;
    }
    public function getNcsaNote()
    {
    return $this->ncsa_note;
    }
    public function setNcsaNote( $ncsa_note)
    {
    $this->ncsa_note = $ncsa_note;
    return $this;
    }
    public function getAdaptiveCruiseControlAcc()
    {
    return $this->adaptive_cruise_control_acc;
    }
    public function setAdaptiveCruiseControlAcc( $adaptive_cruise_control_acc)
    {
    $this->adaptive_cruise_control_acc = $adaptive_cruise_control_acc;
    return $this;
    }
    public function getCrashImminentBrakingCib()
    {
    return $this->crash_imminent_braking_cib;
    }
    public function setCrashImminentBrakingCib( $crash_imminent_braking_cib)
    {
    $this->crash_imminent_braking_cib = $crash_imminent_braking_cib;
    return $this;
    }
    public function getBlindSpotWarningBsw()
    {
    return $this->blind_spot_warning_bsw;
    }
    public function setBlindSpotWarningBsw( $blind_spot_warning_bsw)
    {
    $this->blind_spot_warning_bsw = $blind_spot_warning_bsw;
    return $this;
    }
    public function getForwardCollisionWarningFcw()
    {
    return $this->forward_collision_warning_fcw;
    }
    public function setForwardCollisionWarningFcw( $forward_collision_warning_fcw)
    {
    $this->forward_collision_warning_fcw = $forward_collision_warning_fcw;
    return $this;
    }
    public function getLaneDepartureWarningLdw()
    {
    return $this->lane_departure_warning_ldw;
    }
    public function setLaneDepartureWarningLdw( $lane_departure_warning_ldw)
    {
    $this->lane_departure_warning_ldw = $lane_departure_warning_ldw;
    return $this;
    }
    public function getLaneKeepingAssistanceLka()
    {
    return $this->lane_keeping_assistance_lka;
    }
    public function setLaneKeepingAssistanceLka( $lane_keeping_assistance_lka)
    {
    $this->lane_keeping_assistance_lka = $lane_keeping_assistance_lka;
    return $this;
    }
    public function getBackupCamera()
    {
    return $this->backup_camera;
    }
    public function setBackupCamera( $backup_camera)
    {
    $this->backup_camera = $backup_camera;
    return $this;
    }
    public function getParkingAssist()
    {
    return $this->parking_assist;
    }
    public function setParkingAssist( $parking_assist)
    {
    $this->parking_assist = $parking_assist;
    return $this;
    }
    public function getBusLengthFeet()
    {
    return $this->bus_length_feet;
    }
    public function setBusLengthFeet( $bus_length_feet)
    {
    $this->bus_length_feet = $bus_length_feet;
    return $this;
    }
    public function getBusFloorConfigurationType()
    {
    return $this->bus_floor_configuration_type;
    }
    public function setBusFloorConfigurationType( $bus_floor_configuration_type)
    {
    $this->bus_floor_configuration_type = $bus_floor_configuration_type;
    return $this;
    }
    public function getBusType()
    {
    return $this->bus_type;
    }
    public function setBusType( $bus_type)
    {
    $this->bus_type = $bus_type;
    return $this;
    }
    public function getOtherBusInfo()
    {
    return $this->other_bus_info;
    }
    public function setOtherBusInfo( $other_bus_info)
    {
    $this->other_bus_info = $other_bus_info;
    return $this;
    }
    public function getCustomMotorcycleType()
    {
    return $this->custom_motorcycle_type;
    }
    public function setCustomMotorcycleType( $custom_motorcycle_type)
    {
    $this->custom_motorcycle_type = $custom_motorcycle_type;
    return $this;
    }
    public function getMotorcycleSuspensionType()
    {
    return $this->motorcycle_suspension_type;
    }
    public function setMotorcycleSuspensionType( $motorcycle_suspension_type)
    {
    $this->motorcycle_suspension_type = $motorcycle_suspension_type;
    return $this;
    }
    public function getMotorcycleChassisType()
    {
    return $this->motorcycle_chassis_type;
    }
    public function setMotorcycleChassisType( $motorcycle_chassis_type)
    {
    $this->motorcycle_chassis_type = $motorcycle_chassis_type;
    return $this;
    }
    public function getOtherMotorcycleInfo()
    {
    return $this->other_motorcycle_info;
    }
    public function setOtherMotorcycleInfo( $other_motorcycle_info)
    {
    $this->other_motorcycle_info = $other_motorcycle_info;
    return $this;
    }
    public function getDynamicBrakeSupportDbs()
    {
    return $this->dynamic_brake_support_dbs;
    }
    public function setDynamicBrakeSupportDbs( $dynamic_brake_support_dbs)
    {
    $this->dynamic_brake_support_dbs = $dynamic_brake_support_dbs;
    return $this;
    }
    public function getPedestrianAutomaticEmergencyBrakingPaeb()
    {
    return $this->pedestrian_automatic_emergency_braking_paeb;
    }
    public function setPedestrianAutomaticEmergencyBrakingPaeb( $pedestrian_automatic_emergency_braking_paeb)
    {
    $this->pedestrian_automatic_emergency_braking_paeb = $pedestrian_automatic_emergency_braking_paeb;
    return $this;
    }
    public function getAutomaticAndAdvancedCrashNotificationAacn()
    {
    return $this->automatic_and_advanced_crash_notification_aacn;
    }
    public function setAutomaticAndAdvancedCrashNotificationAacn( $automatic_and_advanced_crash_notification_aacn)
    {
    $this->automatic_and_advanced_crash_notification_aacn = $automatic_and_advanced_crash_notification_aacn;
    return $this;
    }
    public function getDaytimeRunningLightDrl()
    {
    return $this->daytime_running_light_drl;
    }
    public function setDaytimeRunningLightDrl( $daytime_running_light_drl)
    {
    $this->daytime_running_light_drl = $daytime_running_light_drl;
    return $this;
    }
    public function getHeadlampLightSource()
    {
    return $this->headlamp_light_source;
    }
    public function setHeadlampLightSource( $headlamp_light_source)
    {
    $this->headlamp_light_source = $headlamp_light_source;
    return $this;
    }
    public function getSemiautomaticHeadlampBeamSwitching()
    {
    return $this->semiautomatic_headlamp_beam_switching;
    }
    public function setSemiautomaticHeadlampBeamSwitching( $semiautomatic_headlamp_beam_switching)
    {
    $this->semiautomatic_headlamp_beam_switching = $semiautomatic_headlamp_beam_switching;
    return $this;
    }
    public function getAdaptiveDrivingBeamAdb()
    {
    return $this->adaptive_driving_beam_adb;
    }
    public function setAdaptiveDrivingBeamAdb( $adaptive_driving_beam_adb)
    {
    $this->adaptive_driving_beam_adb = $adaptive_driving_beam_adb;
    return $this;
    }
    public function getRearCrossTrafficAlert()
    {
    return $this->rear_cross_traffic_alert;
    }
    public function setRearCrossTrafficAlert( $rear_cross_traffic_alert)
    {
    $this->rear_cross_traffic_alert = $rear_cross_traffic_alert;
    return $this;
    }
    public function getRearAutomaticEmergencyBraking()
    {
    return $this->rear_automatic_emergency_braking;
    }
    public function setRearAutomaticEmergencyBraking( $rear_automatic_emergency_braking)
    {
    $this->rear_automatic_emergency_braking = $rear_automatic_emergency_braking;
    return $this;
    }
    public function getBlindSpotInterventionBsi()
    {
    return $this->blind_spot_intervention_bsi;
    }
    public function setBlindSpotInterventionBsi( $blind_spot_intervention_bsi)
    {
    $this->blind_spot_intervention_bsi = $blind_spot_intervention_bsi;
    return $this;
    }
    public function getLaneCenteringAssistance()
    {
    return $this->lane_centering_assistance;
    }
    public function setLaneCenteringAssistance( $lane_centering_assistance)
    {
    $this->lane_centering_assistance = $lane_centering_assistance;
    return $this;
    }
    public function getDestinationMarket()
    {
        return $this->destination_market;
    }

    public function setDestinationMarket( $destination_market): self
    {
        $this->destination_market = $destination_market;

        return $this;
    }

    public function getManufacturerName()
    {
        return $this->manufacturer_name;
    }

    public function setManufacturerName( $manufacturer_name): self
    {
        $this->manufacturer_name = $manufacturer_name;

        return $this;
    }

    public function getPlantCity()
    {
        return $this->plant_city;
    }

    public function setPlantCity( $plant_city): self
    {
        $this->plant_city = $plant_city;

        return $this;
    }

    public function getSeries()
    {
        return $this->series;
    }

    public function setSeries( $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getVehicleType()
    {
        return $this->vehicle_type;
    }

    public function setVehicleType( $vehicle_type): self
    {
        $this->vehicle_type = $vehicle_type;

        return $this;
    }

    public function getPlantCountry()
    {
        return $this->plant_country;
    }

    public function setPlantCountry( $plant_country): self
    {
        $this->plant_country = $plant_country;

        return $this;
    }

    public function getPlantCompanyName()
    {
        return $this->plant_company_name;
    }

    public function setPlantCompanyName( $plant_company_name): self
    {
        $this->plant_company_name = $plant_company_name;

        return $this;
    }

    public function getPlantState()
    {
        return $this->plant_state;
    }

    public function setPlantState( $plant_state): self
    {
        $this->plant_state = $plant_state;

        return $this;
    }

    public function getTrim2()
    {
        return $this->trim2;
    }

    public function setTrim2( $trim2): self
    {
        $this->trim2 = $trim2;

        return $this;
    }

       public function getSeries2()
    {
        return $this->series2;
    }

    public function setSeries2( $series2): self
    {
        $this->series2 = $series2;

        return $this;
    }
    
     public function getNote()
    {
        return $this->note;
    }

    public function setNote( $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getBasePrice(): ?int
    {
        return $this->base_price;
    }

    public function setBasePrice(DecimalType $base_price): self
    {
        $this->base_price = $base_price;

        return $this;
    }

     public function getNonLandUse()
    {
        return $this->non_land_use;
    }

    public function setNonLandUse( $non_land_use): self
    {
        $this->non_land_use = $non_land_use;

        return $this;
    }

    public function getBodyClass()
    {
        return $this->body_class;
    }

    public function setBodyClass( $body_class): self
    {
        $this->body_class = $body_class;

        return $this;
    }

    public function getDoors()
    {
        return $this->doors;
    }

    public function setDoors( $doors): self
    {
        $this->doors = $doors;

        return $this;
    }

    public function getWindows()
    {
        return $this->windows;
    }

    public function setWindows( $windows): self
    {
        $this->windows = $windows;

        return $this;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear( $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getWheelBaseType()
    {
        return $this->wheel_base_type;
    }

    public function setWheelBaseType( $wheel_base_type): self
    {
        $this->wheel_base_type = $wheel_base_type;

        return $this;
    }

    public function getMake()
    {
        return $this->make;
    }

    public function setMake( $make): self
    {
        $this->make = $make;

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel( $model): self
    {
        $this->model = $model;

        return $this;
    }
}