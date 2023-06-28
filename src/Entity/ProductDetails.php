<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityIdTrait;
use App\Entity\Trait\ModifiedAtTrait;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
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

    #[ORM\OneToOne(inversedBy: 'product_details', targetEntity: Product::class, cascade: [
        'persist',
        'remove',
    ])]
    // #[JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    public function __construct()
    {
    }

    /**
     * @return string|null
     */
    public function getPossibleValues()
    {
        return $this->possible_values;
    }

    /**
     * @param $possible_values
     *
     * @return $this
     */
    public function setPossibleValues($possible_values): self
    {
        $this->possible_values = $possible_values;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSuggestedVin()
    {
        return $this->suggested_vin;
    }

    /**
     * @param $suggested_vin
     *
     * @return $this
     */
    public function setSuggestedVin($suggested_vin): self
    {
        $this->suggested_vin = $suggested_vin;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * @param $vin
     *
     * @return $this
     */
    public function setVin($vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVehicleDescriptor()
    {
        return $this->vehicle_descriptor;
    }

    /**
     * @param $vehicle_descriptor
     *
     * @return $this
     */
    public function setVehicleDescriptor($vehicle_descriptor): self
    {
        $this->vehicle_descriptor = $vehicle_descriptor;

        return $this;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param  Product  $product
     *
     * @return $this
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTrackWidthInches()
    {
        return $this->track_width_inches;
    }

    /**
     * @param $track_width_inches
     *
     * @return $this
     */
    public function setTrackWidthInches($track_width_inches)
    {
        $this->track_width_inches = $track_width_inches;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGrossVehicleWeightRatingFrom()
    {
        return $this->gross_vehicle_weight_rating_from;
    }

    /**
     * @param $gross_vehicle_weight_rating_from
     *
     * @return $this
     */
    public function setGrossVehicleWeightRatingFrom(
        $gross_vehicle_weight_rating_from
    ) {
        $this->gross_vehicle_weight_rating_from
            = $gross_vehicle_weight_rating_from;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBedLengthInches()
    {
        return $this->bed_length_inches;
    }

    /**
     * @param $bed_length_inches
     *
     * @return $this
     */
    public function setBedLengthInches($bed_length_inches)
    {
        $this->bed_length_inches = $bed_length_inches;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurbWeightPounds()
    {
        return $this->curb_weight_pounds;
    }

    /**
     * @param $curb_weight_pounds
     *
     * @return $this
     */
    public function setCurbWeightPounds($curb_weight_pounds)
    {
        $this->curb_weight_pounds = $curb_weight_pounds;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWheelBaseInchesFrom()
    {
        return $this->wheel_base_inches_from;
    }

    /**
     * @param $wheel_base_inches_from
     *
     * @return $this
     */
    public function setWheelBaseInchesFrom($wheel_base_inches_from)
    {
        $this->wheel_base_inches_from = $wheel_base_inches_from;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWheelBaseInchesTo()
    {
        return $this->wheel_base_inches_to;
    }

    /**
     * @param $wheel_base_inches_to
     *
     * @return $this
     */
    public function setWheelBaseInchesTo($wheel_base_inches_to)
    {
        $this->wheel_base_inches_to = $wheel_base_inches_to;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGrossCombinationWeightRatingFrom()
    {
        return $this->gross_combination_weight_rating_from;
    }

    /**
     * @param $gross_combination_weight_rating_from
     *
     * @return $this
     */
    public function setGrossCombinationWeightRatingFrom(
        $gross_combination_weight_rating_from
    ) {
        $this->gross_combination_weight_rating_from
            = $gross_combination_weight_rating_from;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGrossCombinationWeightRatingTo()
    {
        return $this->gross_combination_weight_rating_to;
    }

    /**
     * @param $gross_combination_weight_rating_to
     *
     * @return $this
     */
    public function setGrossCombinationWeightRatingTo(
        $gross_combination_weight_rating_to
    ) {
        $this->gross_combination_weight_rating_to
            = $gross_combination_weight_rating_to;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGrossVehicleWeightRatingTo()
    {
        return $this->gross_vehicle_weight_rating_to;
    }

    /**
     * @param $gross_vehicle_weight_rating_to
     *
     * @return $this
     */
    public function setGrossVehicleWeightRatingTo(
        $gross_vehicle_weight_rating_to
    ) {
        $this->gross_vehicle_weight_rating_to = $gross_vehicle_weight_rating_to;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBedType()
    {
        return $this->bed_type;
    }

    /**
     * @param $bed_type
     *
     * @return $this
     */
    public function setBedType($bed_type)
    {
        $this->bed_type = $bed_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCabType()
    {
        return $this->cab_type;
    }

    /**
     * @param $cab_type
     *
     * @return $this
     */
    public function setCabType($cab_type)
    {
        $this->cab_type = $cab_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTrailerTypeConnection()
    {
        return $this->trailer_type_connection;
    }

    /**
     * @param $trailer_type_connection
     *
     * @return $this
     */
    public function setTrailerTypeConnection($trailer_type_connection)
    {
        $this->trailer_type_connection = $trailer_type_connection;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTrailerBodyType()
    {
        return $this->trailer_body_type;
    }

    /**
     * @param $trailer_body_type
     *
     * @return $this
     */
    public function setTrailerBodyType($trailer_body_type)
    {
        $this->trailer_body_type = $trailer_body_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTrailerLengthFeet()
    {
        return $this->trailer_length_feet;
    }

    /**
     * @param $trailer_length_feet
     *
     * @return $this
     */
    public function setTrailerLengthFeet($trailer_length_feet)
    {
        $this->trailer_length_feet = $trailer_length_feet;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOtherTrailerInfo()
    {
        return $this->other_trailer_info;
    }

    /**
     * @param $other_trailer_info
     *
     * @return $this
     */
    public function setOtherTrailerInfo($other_trailer_info)
    {
        $this->other_trailer_info = $other_trailer_info;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberOfWheels()
    {
        return $this->number_of_wheels;
    }

    /**
     * @param $number_of_wheels
     *
     * @return $this
     */
    public function setNumberOfWheels($number_of_wheels)
    {
        $this->number_of_wheels = $number_of_wheels;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWheelSizeFrontInches()
    {
        return $this->wheel_size_front_inches;
    }

    /**
     * @param $wheel_size_front_inches
     *
     * @return $this
     */
    public function setWheelSizeFrontInches($wheel_size_front_inches)
    {
        $this->wheel_size_front_inches = $wheel_size_front_inches;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWheelSizeRearInches()
    {
        return $this->wheel_size_rear_inches;
    }

    /**
     * @param $wheel_size_rear_inches
     *
     * @return $this
     */
    public function setWheelSizeRearInches($wheel_size_rear_inches)
    {
        $this->wheel_size_rear_inches = $wheel_size_rear_inches;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEntertainmentSystem()
    {
        return $this->entertainment_system;
    }

    /**
     * @param $entertainment_system
     *
     * @return $this
     */
    public function setEntertainmentSystem($entertainment_system)
    {
        $this->entertainment_system = $entertainment_system;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSteeringLocation()
    {
        return $this->steering_location;
    }


    /**
     * @param $steering_location
     *
     * @return $this
     */
    public function setSteeringLocation($steering_location)
    {
        $this->steering_location = $steering_location;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberOfSeats()
    {
        return $this->number_of_seats;
    }

    /**
     * @param $number_of_seats
     *
     * @return $this
     */
    public function setNumberOfSeats($number_of_seats)
    {
        $this->number_of_seats = $number_of_seats;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberOfSeatRows()
    {
        return $this->number_of_seat_rows;
    }

    /**
     * @param $number_of_seat_rows
     *
     * @return $this
     */
    public function setNumberOfSeatRows($number_of_seat_rows)
    {
        $this->number_of_seat_rows = $number_of_seat_rows;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransmissionStyle()
    {
        return $this->transmission_style;
    }

    /**
     * @param $transmission_style
     *
     * @return $this
     */
    public function setTransmissionStyle($transmission_style)
    {
        $this->transmission_style = $transmission_style;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransmissionSpeeds()
    {
        return $this->transmission_speeds;
    }

    /**
     * @param $transmission_speeds
     *
     * @return $this
     */
    public function setTransmissionSpeeds($transmission_speeds)
    {
        $this->transmission_speeds = $transmission_speeds;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDriveType()
    {
        return $this->drive_type;
    }

    /**
     * @param $drive_type
     *
     * @return $this
     */
    public function setDriveType($drive_type)
    {
        $this->drive_type = $drive_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAxles()
    {
        return $this->axles;
    }

    /**
     * @param $axles
     *
     * @return $this
     */
    public function setAxles($axles)
    {
        $this->axles = $axles;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAxleConfiguration()
    {
        return $this->axle_configuration;
    }

    /**
     * @param $axle_configuration
     *
     * @return $this
     */
    public function setAxleConfiguration($axle_configuration)
    {
        $this->axle_configuration = $axle_configuration;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrakeSystemType()
    {
        return $this->brake_system_type;
    }

    /**
     * @param $brake_system_type
     *
     * @return $this
     */
    public function setBrakeSystemType($brake_system_type)
    {
        $this->brake_system_type = $brake_system_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrakeSystemDescription()
    {
        return $this->brake_system_description;
    }

    /**
     * @param $brake_system_description
     *
     * @return $this
     */
    public function setBrakeSystemDescription($brake_system_description)
    {
        $this->brake_system_description = $brake_system_description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOtherBatteryInfo()
    {
        return $this->other_battery_info;
    }

    /**
     * @param $other_battery_info
     *
     * @return $this
     */
    public function setOtherBatteryInfo($other_battery_info)
    {
        $this->other_battery_info = $other_battery_info;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBatteryType()
    {
        return $this->battery_type;
    }

    /**
     * @param $battery_type
     *
     * @return $this
     */
    public function setBatteryType($battery_type)
    {
        $this->battery_type = $battery_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberOfBatteryCellsPerModule()
    {
        return $this->number_of_battery_cells_per_module;
    }

    /**
     * @param $number_of_battery_cells_per_module
     *
     * @return $this
     */
    public function setNumberOfBatteryCellsPerModule(
        $number_of_battery_cells_per_module
    ) {
        $this->number_of_battery_cells_per_module
            = $number_of_battery_cells_per_module;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBatteryCurrentAmpsFrom()
    {
        return $this->battery_current_amps_from;
    }

    /**
     * @param $battery_current_amps_from
     *
     * @return $this
     */
    public function setBatteryCurrentAmpsFrom($battery_current_amps_from)
    {
        $this->battery_current_amps_from = $battery_current_amps_from;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBatteryVoltageVoltsFrom()
    {
        return $this->battery_voltage_volts_from;
    }

    /**
     * @param $battery_voltage_volts_from
     *
     * @return $this
     */
    public function setBatteryVoltageVoltsFrom($battery_voltage_volts_from)
    {
        $this->battery_voltage_volts_from = $battery_voltage_volts_from;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBatteryEnergyKwhFrom()
    {
        return $this->battery_energy_kwh_from;
    }

    /**
     * @param $battery_energy_kwh_from
     *
     * @return $this
     */
    public function setBatteryEnergyKwhFrom($battery_energy_kwh_from)
    {
        $this->battery_energy_kwh_from = $battery_energy_kwh_from;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEvDriveUnit()
    {
        return $this->ev_drive_unit;
    }

    /**
     * @param $ev_drive_unit
     *
     * @return $this
     */
    public function setEvDriveUnit($ev_drive_unit)
    {
        $this->ev_drive_unit = $ev_drive_unit;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBatteryCurrentAmpsTo()
    {
        return $this->battery_current_amps_to;
    }

    /**
     * @param $battery_current_amps_to
     *
     * @return $this
     */
    public function setBatteryCurrentAmpsTo($battery_current_amps_to)
    {
        $this->battery_current_amps_to = $battery_current_amps_to;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBatteryVoltageVoltsTo()
    {
        return $this->battery_voltage_volts_to;
    }

    /**
     * @param $battery_voltage_volts_to
     *
     * @return $this
     */
    public function setBatteryVoltageVoltsTo($battery_voltage_volts_to)
    {
        $this->battery_voltage_volts_to = $battery_voltage_volts_to;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBatteryEnergyKwhTo()
    {
        return $this->battery_energy_kwh_to;
    }

    /**
     * @param $battery_energy_kwh_to
     *
     * @return $this
     */
    public function setBatteryEnergyKwhTo($battery_energy_kwh_to)
    {
        $this->battery_energy_kwh_to = $battery_energy_kwh_to;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberOfBatteryModulesPerPack()
    {
        return $this->number_of_battery_modules_per_pack;
    }

    /**
     * @param $number_of_battery_modules_per_pack
     *
     * @return $this
     */
    public function setNumberOfBatteryModulesPerPack(
        $number_of_battery_modules_per_pack
    ) {
        $this->number_of_battery_modules_per_pack
            = $number_of_battery_modules_per_pack;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberOfBatteryPacksPerVehicle()
    {
        return $this->number_of_battery_packs_per_vehicle;
    }

    /**
     * @param $number_of_battery_packs_per_vehicle
     *
     * @return $this
     */
    public function setNumberOfBatteryPacksPerVehicle(
        $number_of_battery_packs_per_vehicle
    ) {
        $this->number_of_battery_packs_per_vehicle
            = $number_of_battery_packs_per_vehicle;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getChargerLevel()
    {
        return $this->charger_level;
    }

    /**
     * @param $charger_level
     *
     * @return $this
     */
    public function setChargerLevel($charger_level)
    {
        $this->charger_level = $charger_level;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getChargerPowerKw()
    {
        return $this->charger_power_kw;
    }

    /**
     * @param $charger_power_kw
     *
     * @return $this
     */
    public function setChargerPowerKw($charger_power_kw)
    {
        $this->charger_power_kw = $charger_power_kw;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEngineNumberOfCylinders()
    {
        return $this->engine_number_of_cylinders;
    }

    /**
     * @param $engine_number_of_cylinders
     *
     * @return $this
     */
    public function setEngineNumberOfCylinders($engine_number_of_cylinders)
    {
        $this->engine_number_of_cylinders = $engine_number_of_cylinders;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDisplacementCc()
    {
        return $this->displacement_cc;
    }

    /**
     * @param $displacement_cc
     *
     * @return $this
     */
    public function setDisplacementCc($displacement_cc)
    {
        $this->displacement_cc = $displacement_cc;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDisplacementCi()
    {
        return $this->displacement_ci;
    }

    /**
     * @param $displacement_ci
     *
     * @return $this
     */
    public function setDisplacementCi($displacement_ci)
    {
        $this->displacement_ci = $displacement_ci;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDisplacementL()
    {
        return $this->displacement_l;
    }

    /**
     * @param $displacement_l
     *
     * @return $this
     */
    public function setDisplacementL($displacement_l)
    {
        $this->displacement_l = $displacement_l;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEngineStrokeCycles()
    {
        return $this->engine_stroke_cycles;
    }

    /**
     * @param $engine_stroke_cycles
     *
     * @return $this
     */
    public function setEngineStrokeCycles($engine_stroke_cycles)
    {
        $this->engine_stroke_cycles = $engine_stroke_cycles;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEngineModel()
    {
        return $this->engine_model;
    }

    /**
     * @param $engine_model
     *
     * @return $this
     */
    public function setEngineModel($engine_model)
    {
        $this->engine_model = $engine_model;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEnginePowerKw()
    {
        return $this->engine_power_kw;
    }

    /**
     * @param $engine_power_kw
     *
     * @return $this
     */
    public function setEnginePowerKw($engine_power_kw)
    {
        $this->engine_power_kw = $engine_power_kw;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFuelTypePrimary()
    {
        return $this->fuel_type_primary;
    }

    /**
     * @param $fuel_type_primary
     *
     * @return $this
     */
    public function setFuelTypePrimary($fuel_type_primary)
    {
        $this->fuel_type_primary = $fuel_type_primary;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValveTrainDesign()
    {
        return $this->valve_train_design;
    }

    /**
     * @param $valve_train_design
     *
     * @return $this
     */
    public function setValveTrainDesign($valve_train_design)
    {
        $this->valve_train_design = $valve_train_design;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEngineConfiguration()
    {
        return $this->engine_configuration;
    }

    /**
     * @param $engine_configuration
     *
     * @return $this
     */
    public function setEngineConfiguration($engine_configuration)
    {
        $this->engine_configuration = $engine_configuration;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFuelTypeSecondary()
    {
        return $this->fuel_type_secondary;
    }

    /**
     * @param $fuel_type_secondary
     *
     * @return $this
     */
    public function setFuelTypeSecondary($fuel_type_secondary)
    {
        $this->fuel_type_secondary = $fuel_type_secondary;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFuelDeliveryFuelInjectionType()
    {
        return $this->fuel_delivery_fuel_injection_type;
    }

    /**
     * @param $fuel_delivery_fuel_injection_type
     *
     * @return $this
     */
    public function setFuelDeliveryFuelInjectionType(
        $fuel_delivery_fuel_injection_type
    ) {
        $this->fuel_delivery_fuel_injection_type
            = $fuel_delivery_fuel_injection_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEngineBrakeHpFrom()
    {
        return $this->engine_brake_hp_from;
    }

    /**
     * @param $engine_brake_hp_from
     *
     * @return $this
     */
    public function setEngineBrakeHpFrom($engine_brake_hp_from)
    {
        $this->engine_brake_hp_from = $engine_brake_hp_from;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCoolingType()
    {
        return $this->cooling_type;
    }

    /**
     * @param $cooling_type
     *
     * @return $this
     */
    public function setCoolingType($cooling_type)
    {
        $this->cooling_type = $cooling_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEngineBrakeHpTo()
    {
        return $this->engine_brake_hp_to;
    }

    /**
     * @param $engine_brake_hp_to
     *
     * @return $this
     */
    public function setEngineBrakeHpTo($engine_brake_hp_to)
    {
        $this->engine_brake_hp_to = $engine_brake_hp_to;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getElectrificationLevel()
    {
        return $this->electrification_level;
    }

    /**
     * @param $electrification_level
     *
     * @return $this
     */
    public function setElectrificationLevel($electrification_level)
    {
        $this->electrification_level = $electrification_level;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOtherEngineInfo()
    {
        return $this->other_engine_info;
    }

    /**
     * @param $other_engine_info
     *
     * @return $this
     */
    public function setOtherEngineInfo($other_engine_info)
    {
        $this->other_engine_info = $other_engine_info;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTurbo()
    {
        return $this->turbo;
    }

    /**
     * @param $turbo
     *
     * @return $this
     */
    public function setTurbo($turbo)
    {
        $this->turbo = $turbo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTopSpeedMph()
    {
        return $this->top_speed_mph;
    }

    /**
     * @param $top_speed_mph
     *
     * @return $this
     */
    public function setTopSpeedMph($top_speed_mph)
    {
        $this->top_speed_mph = $top_speed_mph;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEngineManufacturer()
    {
        return $this->engine_manufacturer;
    }

    /**
     * @param $engine_manufacturer
     *
     * @return $this
     */
    public function setEngineManufacturer($engine_manufacturer)
    {
        $this->engine_manufacturer = $engine_manufacturer;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPretensioner()
    {
        return $this->pretensioner;
    }

    /**
     * @param $pretensioner
     *
     * @return $this
     */
    public function setPretensioner($pretensioner)
    {
        $this->pretensioner = $pretensioner;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSeatBeltType()
    {
        return $this->seat_belt_type;
    }

    /**
     * @param $seat_belt_type
     *
     * @return $this
     */
    public function setSeatBeltType($seat_belt_type)
    {
        $this->seat_belt_type = $seat_belt_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOtherRestraintSystemInfo()
    {
        return $this->other_restraint_system_info;
    }

    /**
     * @param $other_restraint_system_info
     *
     * @return $this
     */
    public function setOtherRestraintSystemInfo($other_restraint_system_info)
    {
        $this->other_restraint_system_info = $other_restraint_system_info;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurtainAirBagLocations()
    {
        return $this->curtain_air_bag_locations;
    }

    /**
     * @param $curtain_air_bag_locations
     *
     * @return $this
     */
    public function setCurtainAirBagLocations($curtain_air_bag_locations)
    {
        $this->curtain_air_bag_locations = $curtain_air_bag_locations;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSeatCushionAirBagLocations()
    {
        return $this->seat_cushion_air_bag_locations;
    }

    /**
     * @param $seat_cushion_air_bag_locations
     *
     * @return $this
     */
    public function setSeatCushionAirBagLocations(
        $seat_cushion_air_bag_locations
    ) {
        $this->seat_cushion_air_bag_locations = $seat_cushion_air_bag_locations;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrontAirBagLocations()
    {
        return $this->front_air_bag_locations;
    }

    /**
     * @param $front_air_bag_locations
     *
     * @return $this
     */
    public function setFrontAirBagLocations($front_air_bag_locations)
    {
        $this->front_air_bag_locations = $front_air_bag_locations;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getKneeAirBagLocations()
    {
        return $this->knee_air_bag_locations;
    }

    /**
     * @param $knee_air_bag_locations
     *
     * @return $this
     */
    public function setKneeAirBagLocations($knee_air_bag_locations)
    {
        $this->knee_air_bag_locations = $knee_air_bag_locations;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSideAirBagLocations()
    {
        return $this->side_air_bag_locations;
    }

    /**
     * @param $side_air_bag_locations
     *
     * @return $this
     */
    public function setSideAirBagLocations($side_air_bag_locations)
    {
        $this->side_air_bag_locations = $side_air_bag_locations;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAntiLockBrakingSystemAbs()
    {
        return $this->anti_lock_braking_system_abs;
    }

    /**
     * @param $anti_lock_braking_system_abs
     *
     * @return $this
     */
    public function setAntiLockBrakingSystemAbs($anti_lock_braking_system_abs)
    {
        $this->anti_lock_braking_system_abs = $anti_lock_braking_system_abs;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getElectronicStabilityControlEsc()
    {
        return $this->electronic_stability_control_esc;
    }

    /**
     * @param $electronic_stability_control_esc
     *
     * @return $this
     */
    public function setElectronicStabilityControlEsc(
        $electronic_stability_control_esc
    ) {
        $this->electronic_stability_control_esc
            = $electronic_stability_control_esc;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTractionControl()
    {
        return $this->traction_control;
    }

    /**
     * @param $traction_control
     *
     * @return $this
     */
    public function setTractionControl($traction_control)
    {
        $this->traction_control = $traction_control;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTirePressureMonitoringSystemTpmsType()
    {
        return $this->tire_pressure_monitoring_system_tpms_type;
    }

    /**
     * @param $tire_pressure_monitoring_system_tpms_type
     *
     * @return $this
     */
    public function setTirePressureMonitoringSystemTpmsType(
        $tire_pressure_monitoring_system_tpms_type
    ) {
        $this->tire_pressure_monitoring_system_tpms_type
            = $tire_pressure_monitoring_system_tpms_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getActiveSafetySystemNote()
    {
        return $this->active_safety_system_note;
    }

    /**
     * @param $active_safety_system_note
     *
     * @return $this
     */
    public function setActiveSafetySystemNote($active_safety_system_note)
    {
        $this->active_safety_system_note = $active_safety_system_note;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAutoReverseSystemForWindowsAndSunroofs()
    {
        return $this->auto_reverse_system_for_windows_and_sunroofs;
    }

    /**
     * @param $auto_reverse_system_for_windows_and_sunroofs
     *
     * @return $this
     */
    public function setAutoReverseSystemForWindowsAndSunroofs(
        $auto_reverse_system_for_windows_and_sunroofs
    ) {
        $this->auto_reverse_system_for_windows_and_sunroofs
            = $auto_reverse_system_for_windows_and_sunroofs;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAutomaticPedestrianAlertingSoundForHybridAndEvOnly()
    {
        return $this->automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only;
    }

    /**
     * @param $automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only
     *
     * @return $this
     */
    public function setAutomaticPedestrianAlertingSoundForHybridAndEvOnly(
        $automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only
    ) {
        $this->automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only
            = $automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEventDataRecorderEdr()
    {
        return $this->event_data_recorder_edr;
    }

    /**
     * @param $event_data_recorder_edr
     *
     * @return $this
     */
    public function setEventDataRecorderEdr($event_data_recorder_edr)
    {
        $this->event_data_recorder_edr = $event_data_recorder_edr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getKeylessIgnition()
    {
        return $this->keyless_ignition;
    }

    /**
     * @param $keyless_ignition
     *
     * @return $this
     */
    public function setKeylessIgnition($keyless_ignition)
    {
        $this->keyless_ignition = $keyless_ignition;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSaeAutomationLevelFrom()
    {
        return $this->sae_automation_level_from;
    }

    /**
     * @param $sae_automation_level_from
     *
     * @return $this
     */
    public function setSaeAutomationLevelFrom($sae_automation_level_from)
    {
        $this->sae_automation_level_from = $sae_automation_level_from;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSaeAutomationLevelTo()
    {
        return $this->sae_automation_level_to;
    }

    /**
     * @param $sae_automation_level_to
     *
     * @return $this
     */
    public function setSaeAutomationLevelTo($sae_automation_level_to)
    {
        $this->sae_automation_level_to = $sae_automation_level_to;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNcsaBodyType()
    {
        return $this->ncsa_body_type;
    }

    /**
     * @param $ncsa_body_type
     *
     * @return $this
     */
    public function setNcsaBodyType($ncsa_body_type)
    {
        $this->ncsa_body_type = $ncsa_body_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNcsaMake()
    {
        return $this->ncsa_make;
    }

    /**
     * @param $ncsa_make
     *
     * @return $this
     */
    public function setNcsaMake($ncsa_make)
    {
        $this->ncsa_make = $ncsa_make;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNcsaModel()
    {
        return $this->ncsa_model;
    }

    /**
     * @param $ncsa_model
     *
     * @return $this
     */
    public function setNcsaModel($ncsa_model)
    {
        $this->ncsa_model = $ncsa_model;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNcsaNote()
    {
        return $this->ncsa_note;
    }

    /**
     * @param $ncsa_note
     *
     * @return $this
     */
    public function setNcsaNote($ncsa_note)
    {
        $this->ncsa_note = $ncsa_note;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdaptiveCruiseControlAcc()
    {
        return $this->adaptive_cruise_control_acc;
    }

    /**
     * @param $adaptive_cruise_control_acc
     *
     * @return $this
     */
    public function setAdaptiveCruiseControlAcc($adaptive_cruise_control_acc)
    {
        $this->adaptive_cruise_control_acc = $adaptive_cruise_control_acc;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCrashImminentBrakingCib()
    {
        return $this->crash_imminent_braking_cib;
    }

    /**
     * @param $crash_imminent_braking_cib
     *
     * @return $this
     */
    public function setCrashImminentBrakingCib($crash_imminent_braking_cib)
    {
        $this->crash_imminent_braking_cib = $crash_imminent_braking_cib;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBlindSpotWarningBsw()
    {
        return $this->blind_spot_warning_bsw;
    }

    /**
     * @param $blind_spot_warning_bsw
     *
     * @return $this
     */
    public function setBlindSpotWarningBsw($blind_spot_warning_bsw)
    {
        $this->blind_spot_warning_bsw = $blind_spot_warning_bsw;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getForwardCollisionWarningFcw()
    {
        return $this->forward_collision_warning_fcw;
    }

    /**
     * @param $forward_collision_warning_fcw
     *
     * @return $this
     */
    public function setForwardCollisionWarningFcw($forward_collision_warning_fcw
    ) {
        $this->forward_collision_warning_fcw = $forward_collision_warning_fcw;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLaneDepartureWarningLdw()
    {
        return $this->lane_departure_warning_ldw;
    }

    /**
     * @param $lane_departure_warning_ldw
     *
     * @return $this
     */
    public function setLaneDepartureWarningLdw($lane_departure_warning_ldw)
    {
        $this->lane_departure_warning_ldw = $lane_departure_warning_ldw;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLaneKeepingAssistanceLka()
    {
        return $this->lane_keeping_assistance_lka;
    }

    /**
     * @param $lane_keeping_assistance_lka
     *
     * @return $this
     */
    public function setLaneKeepingAssistanceLka($lane_keeping_assistance_lka)
    {
        $this->lane_keeping_assistance_lka = $lane_keeping_assistance_lka;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBackupCamera()
    {
        return $this->backup_camera;
    }

    /**
     * @param $backup_camera
     *
     * @return $this
     */
    public function setBackupCamera($backup_camera)
    {
        $this->backup_camera = $backup_camera;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getParkingAssist()
    {
        return $this->parking_assist;
    }

    /**
     * @param $parking_assist
     *
     * @return $this
     */
    public function setParkingAssist($parking_assist)
    {
        $this->parking_assist = $parking_assist;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBusLengthFeet()
    {
        return $this->bus_length_feet;
    }

    /**
     * @param $bus_length_feet
     *
     * @return $this
     */
    public function setBusLengthFeet($bus_length_feet)
    {
        $this->bus_length_feet = $bus_length_feet;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBusFloorConfigurationType()
    {
        return $this->bus_floor_configuration_type;
    }

    /**
     * @param $bus_floor_configuration_type
     *
     * @return $this
     */
    public function setBusFloorConfigurationType($bus_floor_configuration_type)
    {
        $this->bus_floor_configuration_type = $bus_floor_configuration_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBusType()
    {
        return $this->bus_type;
    }

    /**
     * @param $bus_type
     *
     * @return $this
     */
    public function setBusType($bus_type)
    {
        $this->bus_type = $bus_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOtherBusInfo()
    {
        return $this->other_bus_info;
    }

    /**
     * @param $other_bus_info
     *
     * @return $this
     */
    public function setOtherBusInfo($other_bus_info)
    {
        $this->other_bus_info = $other_bus_info;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomMotorcycleType()
    {
        return $this->custom_motorcycle_type;
    }

    /**
     * @param $custom_motorcycle_type
     *
     * @return $this
     */
    public function setCustomMotorcycleType($custom_motorcycle_type)
    {
        $this->custom_motorcycle_type = $custom_motorcycle_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMotorcycleSuspensionType()
    {
        return $this->motorcycle_suspension_type;
    }

    /**
     * @param $motorcycle_suspension_type
     *
     * @return $this
     */
    public function setMotorcycleSuspensionType($motorcycle_suspension_type)
    {
        $this->motorcycle_suspension_type = $motorcycle_suspension_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMotorcycleChassisType()
    {
        return $this->motorcycle_chassis_type;
    }

    /**
     * @param $motorcycle_chassis_type
     *
     * @return $this
     */
    public function setMotorcycleChassisType($motorcycle_chassis_type)
    {
        $this->motorcycle_chassis_type = $motorcycle_chassis_type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOtherMotorcycleInfo()
    {
        return $this->other_motorcycle_info;
    }

    /**
     * @param $other_motorcycle_info
     *
     * @return $this
     */
    public function setOtherMotorcycleInfo($other_motorcycle_info)
    {
        $this->other_motorcycle_info = $other_motorcycle_info;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDynamicBrakeSupportDbs()
    {
        return $this->dynamic_brake_support_dbs;
    }

    /**
     * @param $dynamic_brake_support_dbs
     *
     * @return $this
     */
    public function setDynamicBrakeSupportDbs($dynamic_brake_support_dbs)
    {
        $this->dynamic_brake_support_dbs = $dynamic_brake_support_dbs;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPedestrianAutomaticEmergencyBrakingPaeb()
    {
        return $this->pedestrian_automatic_emergency_braking_paeb;
    }

    /**
     * @param $pedestrian_automatic_emergency_braking_paeb
     *
     * @return $this
     */
    public function setPedestrianAutomaticEmergencyBrakingPaeb(
        $pedestrian_automatic_emergency_braking_paeb
    ) {
        $this->pedestrian_automatic_emergency_braking_paeb
            = $pedestrian_automatic_emergency_braking_paeb;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAutomaticAndAdvancedCrashNotificationAacn()
    {
        return $this->automatic_and_advanced_crash_notification_aacn;
    }

    /**
     * @param $automatic_and_advanced_crash_notification_aacn
     *
     * @return $this
     */
    public function setAutomaticAndAdvancedCrashNotificationAacn(
        $automatic_and_advanced_crash_notification_aacn
    ) {
        $this->automatic_and_advanced_crash_notification_aacn
            = $automatic_and_advanced_crash_notification_aacn;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDaytimeRunningLightDrl()
    {
        return $this->daytime_running_light_drl;
    }

    /**
     * @param $daytime_running_light_drl
     *
     * @return $this
     */
    public function setDaytimeRunningLightDrl($daytime_running_light_drl)
    {
        $this->daytime_running_light_drl = $daytime_running_light_drl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeadlampLightSource()
    {
        return $this->headlamp_light_source;
    }

    /**
     * @param $headlamp_light_source
     *
     * @return $this
     */
    public function setHeadlampLightSource($headlamp_light_source)
    {
        $this->headlamp_light_source = $headlamp_light_source;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSemiautomaticHeadlampBeamSwitching()
    {
        return $this->semiautomatic_headlamp_beam_switching;
    }

    /**
     * @param $semiautomatic_headlamp_beam_switching
     *
     * @return $this
     */
    public function setSemiautomaticHeadlampBeamSwitching(
        $semiautomatic_headlamp_beam_switching
    ) {
        $this->semiautomatic_headlamp_beam_switching
            = $semiautomatic_headlamp_beam_switching;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdaptiveDrivingBeamAdb()
    {
        return $this->adaptive_driving_beam_adb;
    }

    /**
     * @param $adaptive_driving_beam_adb
     *
     * @return $this
     */
    public function setAdaptiveDrivingBeamAdb($adaptive_driving_beam_adb)
    {
        $this->adaptive_driving_beam_adb = $adaptive_driving_beam_adb;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRearCrossTrafficAlert()
    {
        return $this->rear_cross_traffic_alert;
    }

    /**
     * @param $rear_cross_traffic_alert
     *
     * @return $this
     */
    public function setRearCrossTrafficAlert($rear_cross_traffic_alert)
    {
        $this->rear_cross_traffic_alert = $rear_cross_traffic_alert;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRearAutomaticEmergencyBraking()
    {
        return $this->rear_automatic_emergency_braking;
    }

    /**
     * @param $rear_automatic_emergency_braking
     *
     * @return $this
     */
    public function setRearAutomaticEmergencyBraking(
        $rear_automatic_emergency_braking
    ) {
        $this->rear_automatic_emergency_braking
            = $rear_automatic_emergency_braking;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBlindSpotInterventionBsi()
    {
        return $this->blind_spot_intervention_bsi;
    }

    /**
     * @param $blind_spot_intervention_bsi
     *
     * @return $this
     */
    public function setBlindSpotInterventionBsi($blind_spot_intervention_bsi)
    {
        $this->blind_spot_intervention_bsi = $blind_spot_intervention_bsi;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLaneCenteringAssistance()
    {
        return $this->lane_centering_assistance;
    }

    /**
     * @param $lane_centering_assistance
     *
     * @return $this
     */
    public function setLaneCenteringAssistance($lane_centering_assistance)
    {
        $this->lane_centering_assistance = $lane_centering_assistance;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDestinationMarket()
    {
        return $this->destination_market;
    }


    /**
     * @param $destination_market
     *
     * @return $this
     */
    public function setDestinationMarket($destination_market): self
    {
        $this->destination_market = $destination_market;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getManufacturerName()
    {
        return $this->manufacturer_name;
    }


    /**
     * @param $manufacturer_name
     *
     * @return $this
     */
    public function setManufacturerName($manufacturer_name): self
    {
        $this->manufacturer_name = $manufacturer_name;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getPlantCity()
    {
        return $this->plant_city;
    }


    /**
     * @param $plant_city
     *
     * @return $this
     */
    public function setPlantCity($plant_city): self
    {
        $this->plant_city = $plant_city;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getSeries()
    {
        return $this->series;
    }


    /**
     * @param $series
     *
     * @return $this
     */
    public function setSeries($series): self
    {
        $this->series = $series;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getVehicleType()
    {
        return $this->vehicle_type;
    }


    /**
     * @param $vehicle_type
     *
     * @return $this
     */
    public function setVehicleType($vehicle_type): self
    {
        $this->vehicle_type = $vehicle_type;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getPlantCountry()
    {
        return $this->plant_country;
    }


    /**
     * @param $plant_country
     *
     * @return $this
     */
    public function setPlantCountry($plant_country): self
    {
        $this->plant_country = $plant_country;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getPlantCompanyName()
    {
        return $this->plant_company_name;
    }


    /**
     * @param $plant_company_name
     *
     * @return $this
     */
    public function setPlantCompanyName($plant_company_name): self
    {
        $this->plant_company_name = $plant_company_name;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getPlantState()
    {
        return $this->plant_state;
    }


    /**
     * @param $plant_state
     *
     * @return $this
     */
    public function setPlantState($plant_state): self
    {
        $this->plant_state = $plant_state;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getTrim2()
    {
        return $this->trim2;
    }


    /**
     * @param $trim2
     *
     * @return $this
     */
    public function setTrim2($trim2): self
    {
        $this->trim2 = $trim2;

        return $this;
    }

    public function getSeries2()
    {
        return $this->series2;
    }


    /**
     * @param $series2
     *
     * @return $this
     */
    public function setSeries2($series2): self
    {
        $this->series2 = $series2;

        return $this;
    }

    public function getNote()
    {
        return $this->note;
    }


    /**
     * @param $note
     *
     * @return $this
     */
    public function setNote($note): self
    {
        $this->note = $note;

        return $this;
    }


    /**
     * @return int|null
     */
    public function getBasePrice(): ?int
    {
        return $this->base_price;
    }


    /**
     * @param  DecimalType  $base_price
     *
     * @return $this
     */
    public function setBasePrice(DecimalType $base_price): self
    {
        $this->base_price = $base_price;

        return $this;
    }

    public function getNonLandUse()
    {
        return $this->non_land_use;
    }


    /**
     * @param $non_land_use
     *
     * @return $this
     */
    public function setNonLandUse($non_land_use): self
    {
        $this->non_land_use = $non_land_use;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getBodyClass()
    {
        return $this->body_class;
    }


    /**
     * @param $body_class
     *
     * @return $this
     */
    public function setBodyClass($body_class): self
    {
        $this->body_class = $body_class;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getDoors()
    {
        return $this->doors;
    }


    /**
     * @param $doors
     *
     * @return $this
     */
    public function setDoors($doors): self
    {
        $this->doors = $doors;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getWindows()
    {
        return $this->windows;
    }


    /**
     * @param $windows
     *
     * @return $this
     */
    public function setWindows($windows): self
    {
        $this->windows = $windows;

        return $this;
    }


    /**
     * @return int|null
     */
    public function getYear()
    {
        return $this->year;
    }


    /**
     * @param $year
     *
     * @return $this
     */
    public function setYear($year): self
    {
        $this->year = $year;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getWheelBaseType()
    {
        return $this->wheel_base_type;
    }


    /**
     * @param $wheel_base_type
     *
     * @return $this
     */
    public function setWheelBaseType($wheel_base_type): self
    {
        $this->wheel_base_type = $wheel_base_type;

        return $this;
    }


    /**
     * @return int|null
     */
    public function getMake()
    {
        return $this->make;
    }


    /**
     * @param $make
     *
     * @return $this
     */
    public function setMake($make): self
    {
        $this->make = $make;

        return $this;
    }


    /**
     * @return int|null
     */
    public function getModel()
    {
        return $this->model;
    }


    /**
     * @param $model
     *
     * @return $this
     */
    public function setModel($model): self
    {
        $this->model = $model;

        return $this;
    }

}
