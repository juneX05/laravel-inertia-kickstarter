<template>
    <app-layout>
        <template #bread-crumbs>
            <inertia-link href="/" style="text-decoration: none">
                <v-icon size="16" style="margin-top: -2px">home</v-icon>
            </inertia-link>
          <span class="text-md">
                / Dashboard
            </span>

        </template>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Dashboard
        </h2>
      </template>
      <v-col cols="12">
        <v-row>
          <v-col cols="12" lg="7" md="7" sm="7">
            <v-card>
              <v-card-subtitle>
                <v-row no-gutters>
                  <div>
                    <h4>
                      Today Revenue 2.5%
                      <v-icon small>mdi-arrow-up</v-icon>
                    </h4>
                    <h1 class="mt-2">750,000 TZS</h1>
                  </div>
                  <v-spacer/>
                  <div>
                    <h4>
                      Monthly Revenue 21.5%
                      <v-icon small>mdi-arrow-up</v-icon>
                    </h4>
                    <h1 class="mt-2">750,000 TZS</h1>
                  </div>
                </v-row>
              </v-card-subtitle>
              <v-card-title>

              </v-card-title>
              <v-card-text>
                <apexchart :options="options" :series="series" type="bar" width="80%"></apexchart>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12" lg="5" md="5" sm="5">
            <v-card>
              <v-card-subtitle>
                Rooms Booking Activity
              </v-card-subtitle>
              <v-divider/>
              <v-card-title>
                750,000 TZS
              </v-card-title>
              <v-card-text>
                <apexchart
                    :options="room_booking_activity_chart.chartOptions"
                    :series="room_booking_activity_chart.series"
                    type="donut"
                    width="80%"
                ></apexchart>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>

      </v-col>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Theme/Layouts/AppLayout'

    export default {

      props: ['data', 'errors'],
      components: {
        AppLayout,
      },
      data: function () {
        return {
          room_booking_activity_chart: {
            series: [44, 55, 41],
            chartOptions: {
              chart: {
                id: 'vuechart-example2'
              },
              labels: ['Ensuite', 'Ensuite Deluxe', 'Sharing']
            }
          },
          options: {
            chart: {
              id: 'vuechart-example'
            },
            xaxis: {
              categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
            }
          },
          series: [{
            name: 'series-1',
            data: [30, 40, 45, 50, 49, 60, 70, 91]
          }]
        }
      }
    }
</script>
