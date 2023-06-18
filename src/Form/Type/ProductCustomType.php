<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\ProductDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductCustomType extends AbstractType
{

    /**
     * @param  FormBuilderInterface  $builder
     * @param  array                 $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vin', TextType::class, [
                'label' => 'label.vehicle_identification_number',
                'attr' => [
                    'placeholder' => 'label.vehicle_identification_number',
                    'class' => 'form-control',
                ],
                'mapped' => true,
                'required' => false,
            ])

            ->add('suggested_vin', TextType::class, [
                'label' => 'label.suggested_vin',
                'attr' => [
                    'placeholder' => 'label.suggested_vin',
                    'class' => 'form-control',
                ],
                'mapped' => true,
                // 'required' => false,
            ])
            ->add('possible_values', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('vehicle_descriptor', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('destination_market', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('manufacturer_name', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('plant_city', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('series', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('vehicle_type', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('plant_country', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('plant_company_name', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('plant_state', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('trim2', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('series2', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('note', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('base_price', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('non_land_use', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('body_class', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('doors', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('windows', TextType::class, [
                'label' => 'label.make',
                'attr' => [
                    'placeholder' => 'label.make',
                    'class' => 'form-control',
                ],
                'mapped' => true
            ])
            ->add('wheel_base_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('track_width_inches', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('gross_vehicle_weight_rating_from', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('bed_length_inches', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('curb_weight_pounds', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('wheel_base_inches_from', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('wheel_base_inches_to', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('gross_combination_weight_rating_from', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('gross_combination_weight_rating_to', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('gross_vehicle_weight_rating_to', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('bed_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('cab_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('trailer_type_connection', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('trailer_body_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('trailer_length_feet', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('other_trailer_info', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('number_of_wheels', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('wheel_size_front_inches', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('wheel_size_rear_inches', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('entertainment_system', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('steering_location', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('number_of_seats', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('number_of_seat_rows', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('transmission_style', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('transmission_speeds', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('drive_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('axles', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('axle_configuration', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('brake_system_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('brake_system_description', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('other_battery_info', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('battery_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('number_of_battery_cells_per_module', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('battery_current_amps_from', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('battery_voltage_volts_from', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('battery_energy_kwh_from', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('ev_drive_unit', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('battery_current_amps_to', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('battery_voltage_volts_to', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('battery_energy_kwh_to', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('number_of_battery_modules_per_pack', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('number_of_battery_packs_per_vehicle', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('charger_level', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('charger_power_kw', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('engine_number_of_cylinders', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('displacement_cc', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('displacement_ci', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('displacement_l', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('engine_stroke_cycles', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('engine_model', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('engine_power_kw', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('fuel_type_primary', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('valve_train_design', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('engine_configuration', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('fuel_type_secondary', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('fuel_delivery_fuel_injection_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('engine_brake_hp_from', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('cooling_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('engine_brake_hp_to', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('electrification_level', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('other_engine_info', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('turbo', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('top_speed_mph', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('engine_manufacturer', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('pretensioner', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('seat_belt_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('other_restraint_system_info', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('curtain_air_bag_locations', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('seat_cushion_air_bag_locations', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('front_air_bag_locations', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('knee_air_bag_locations', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('side_air_bag_locations', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('anti_lock_braking_system_abs', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('electronic_stability_control_esc', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('traction_control', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('tire_pressure_monitoring_system_tpms_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('active_safety_system_note', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('auto_reverse_system_for_windows_and_sunroofs', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('event_data_recorder_edr', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('keyless_ignition', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('sae_automation_level_from', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('sae_automation_level_to', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('ncsa_body_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('ncsa_make', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('ncsa_model', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('ncsa_note', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('adaptive_cruise_control_acc', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('crash_imminent_braking_cib', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('blind_spot_warning_bsw', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('forward_collision_warning_fcw', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('lane_departure_warning_ldw', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('lane_keeping_assistance_lka', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('backup_camera', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('parking_assist', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('bus_length_feet', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('bus_floor_configuration_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('bus_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('other_bus_info', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('custom_motorcycle_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('motorcycle_suspension_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('motorcycle_chassis_type', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('other_motorcycle_info', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('dynamic_brake_support_dbs', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('pedestrian_automatic_emergency_braking_paeb', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('automatic_and_advanced_crash_notification_aacn', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('daytime_running_light_drl', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('headlamp_light_source', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('semiautomatic_headlamp_beam_switching', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('adaptive_driving_beam_adb', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('rear_cross_traffic_alert', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('rear_automatic_emergency_braking', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('blind_spot_intervention_bsi', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
            ->add('lane_centering_assistance', TextType::class, [ 'label' => 'label.make', 'attr' => [ 'placeholder' => 'label.make', 'class' => 'form-control', ], 'mapped' => true ])
        ;

        // $builder->get('title')->setRequired(true);
        // $builder->get('images')->setRequired(true);
        // $builder->get('category')->setRequired(true);
        // $builder->get('description')->setRequired(true);
        // $builder->get('price')->setRequired(true);
        $builder->get('suggested_vin')->setRequired(false);
        $builder->get('possible_values')->setRequired(false);
        $builder->get('vehicle_descriptor')->setRequired(false);
        $builder->get('destination_market')->setRequired(false);
        $builder->get('manufacturer_name')->setRequired(false);
        $builder->get('plant_city')->setRequired(false);
        $builder->get('series')->setRequired(false);
        $builder->get('vehicle_type')->setRequired(false);
        $builder->get('plant_country')->setRequired(false);
        $builder->get('plant_company_name')->setRequired(false);
        $builder->get('plant_state')->setRequired(false);
        $builder->get('trim2')->setRequired(false);
        $builder->get('series2')->setRequired(false);
        $builder->get('note')->setRequired(false);
        $builder->get('base_price')->setRequired(false);
        $builder->get('non_land_use')->setRequired(false);
        $builder->get('body_class')->setRequired(false);
        $builder->get('doors')->setRequired(false);
        $builder->get('windows')->setRequired(false);
        $builder->get('wheel_base_type')->setRequired(false);
        $builder->get('track_width_inches')->setRequired(false);
        $builder->get('gross_vehicle_weight_rating_from')->setRequired(false);
        $builder->get('bed_length_inches')->setRequired(false);
        $builder->get('curb_weight_pounds')->setRequired(false);
        $builder->get('wheel_base_inches_from')->setRequired(false);
        $builder->get('wheel_base_inches_to')->setRequired(false);
        $builder->get('gross_combination_weight_rating_from')->setRequired(false);
        $builder->get('gross_combination_weight_rating_to')->setRequired(false);
        $builder->get('gross_vehicle_weight_rating_to')->setRequired(false);
        $builder->get('bed_type')->setRequired(false);
        $builder->get('cab_type')->setRequired(false);
        $builder->get('trailer_type_connection')->setRequired(false);
        $builder->get('trailer_body_type')->setRequired(false);
        $builder->get('trailer_length_feet')->setRequired(false);
        $builder->get('other_trailer_info')->setRequired(false);
        $builder->get('number_of_wheels')->setRequired(false);
        $builder->get('wheel_size_front_inches')->setRequired(false);
        $builder->get('wheel_size_rear_inches')->setRequired(false);
        $builder->get('entertainment_system')->setRequired(false);
        $builder->get('steering_location')->setRequired(false);
        $builder->get('number_of_seats')->setRequired(false);
        $builder->get('number_of_seat_rows')->setRequired(false);
        $builder->get('transmission_style')->setRequired(false);
        $builder->get('transmission_speeds')->setRequired(false);
        $builder->get('drive_type')->setRequired(false);
        $builder->get('axles')->setRequired(false);
        $builder->get('axle_configuration')->setRequired(false);
        $builder->get('brake_system_type')->setRequired(false);
        $builder->get('brake_system_description')->setRequired(false);
        $builder->get('other_battery_info')->setRequired(false);
        $builder->get('battery_type')->setRequired(false);
        $builder->get('number_of_battery_cells_per_module')->setRequired(false);
        $builder->get('battery_current_amps_from')->setRequired(false);
        $builder->get('battery_voltage_volts_from')->setRequired(false);
        $builder->get('battery_energy_kwh_from')->setRequired(false);
        $builder->get('ev_drive_unit')->setRequired(false);
        $builder->get('battery_current_amps_to')->setRequired(false);
        $builder->get('battery_voltage_volts_to')->setRequired(false);
        $builder->get('battery_energy_kwh_to')->setRequired(false);
        $builder->get('number_of_battery_modules_per_pack')->setRequired(false);
        $builder->get('number_of_battery_packs_per_vehicle')->setRequired(false);
        $builder->get('charger_level')->setRequired(false);
        $builder->get('charger_power_kw')->setRequired(false);
        $builder->get('engine_number_of_cylinders')->setRequired(false);
        $builder->get('displacement_cc')->setRequired(false);
        $builder->get('displacement_ci')->setRequired(false);
        $builder->get('displacement_l')->setRequired(false);
        $builder->get('engine_stroke_cycles')->setRequired(false);
        $builder->get('engine_model')->setRequired(false);
        $builder->get('engine_power_kw')->setRequired(false);
        $builder->get('fuel_type_primary')->setRequired(false);
        $builder->get('valve_train_design')->setRequired(false);
        $builder->get('engine_configuration')->setRequired(false);
        $builder->get('fuel_type_secondary')->setRequired(false);
        $builder->get('fuel_delivery_fuel_injection_type')->setRequired(false);
        $builder->get('engine_brake_hp_from')->setRequired(false);
        $builder->get('cooling_type')->setRequired(false);
        $builder->get('engine_brake_hp_to')->setRequired(false);
        $builder->get('electrification_level')->setRequired(false);
        $builder->get('other_engine_info')->setRequired(false);
        $builder->get('turbo')->setRequired(false);
        $builder->get('top_speed_mph')->setRequired(false);
        $builder->get('engine_manufacturer')->setRequired(false);
        $builder->get('pretensioner')->setRequired(false);
        $builder->get('seat_belt_type')->setRequired(false);
        $builder->get('other_restraint_system_info')->setRequired(false);
        $builder->get('curtain_air_bag_locations')->setRequired(false);
        $builder->get('seat_cushion_air_bag_locations')->setRequired(false);
        $builder->get('front_air_bag_locations')->setRequired(false);
        $builder->get('knee_air_bag_locations')->setRequired(false);
        $builder->get('side_air_bag_locations')->setRequired(false);
        $builder->get('anti_lock_braking_system_abs')->setRequired(false);
        $builder->get('electronic_stability_control_esc')->setRequired(false);
        $builder->get('traction_control')->setRequired(false);
        $builder->get('tire_pressure_monitoring_system_tpms_type')->setRequired(false);
        $builder->get('active_safety_system_note')->setRequired(false);
        $builder->get('auto_reverse_system_for_windows_and_sunroofs')->setRequired(false);
        $builder->get('automatic_pedestrian_alerting_sound_for_hybrid_and_ev_only')->setRequired(false);
        $builder->get('event_data_recorder_edr')->setRequired(false);
        $builder->get('keyless_ignition')->setRequired(false);
        $builder->get('sae_automation_level_from')->setRequired(false);
        $builder->get('sae_automation_level_to')->setRequired(false);
        $builder->get('ncsa_body_type')->setRequired(false);
        $builder->get('ncsa_make')->setRequired(false);
        $builder->get('ncsa_model')->setRequired(false);
        $builder->get('ncsa_note')->setRequired(false);
        $builder->get('adaptive_cruise_control_acc')->setRequired(false);
        $builder->get('crash_imminent_braking_cib')->setRequired(false);
        $builder->get('blind_spot_warning_bsw')->setRequired(false);
        $builder->get('forward_collision_warning_fcw')->setRequired(false);
        $builder->get('lane_departure_warning_ldw')->setRequired(false);
        $builder->get('lane_keeping_assistance_lka')->setRequired(false);
        $builder->get('backup_camera')->setRequired(false);
        $builder->get('parking_assist')->setRequired(false);
        $builder->get('bus_length_feet')->setRequired(false);
        $builder->get('bus_floor_configuration_type')->setRequired(false);
        $builder->get('bus_type')->setRequired(false);
        $builder->get('other_bus_info')->setRequired(false);
        $builder->get('custom_motorcycle_type')->setRequired(false);
        $builder->get('motorcycle_suspension_type')->setRequired(false);
        $builder->get('motorcycle_chassis_type')->setRequired(false);
        $builder->get('other_motorcycle_info')->setRequired(false);
        $builder->get('dynamic_brake_support_dbs')->setRequired(false);
        $builder->get('pedestrian_automatic_emergency_braking_paeb')->setRequired(false);
        $builder->get('automatic_and_advanced_crash_notification_aacn')->setRequired(false);
        $builder->get('daytime_running_light_drl')->setRequired(false);
        $builder->get('headlamp_light_source')->setRequired(false);
        $builder->get('semiautomatic_headlamp_beam_switching')->setRequired(false);
        $builder->get('adaptive_driving_beam_adb')->setRequired(false);
        $builder->get('rear_cross_traffic_alert')->setRequired(false);
        $builder->get('rear_automatic_emergency_braking')->setRequired(false);
        $builder->get('blind_spot_intervention_bsi')->setRequired(false);
        $builder->get('lane_centering_assistance')->setRequired(false);
    }

    /**
     * @param  OptionsResolver  $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductDetails::class,
        ]);
    }

}
