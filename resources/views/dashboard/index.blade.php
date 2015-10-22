@extends('shared.full')

@section('content')
<div ng-controller="dashboardController" ng-init="dashboard.init()" ng-cloak>
  <div>
      @include('account.account-header-partial')
      <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Active Trades</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" ng-class="{loadingsection: dashboard.control.isLoading}">


                  <div ng-show="dashboard.control.isLoading">
                    <img src="/cdn/ajax-loader.gif" />
                  </div>
                    <div ng-repeat="trade in dashboard.activeTrades" class="col-md-3 col-xs-12">
                        <div class="tile-stats container">
                          <div class="row name-container">
                            <div class="col-xs-8">
                              <div class="count">
                                <a href="/profile/{{trade.profile.id}}">{{trade.profile.name}}</a>
                              </div>
                            </div>
                            <div class="col-xs-4">
                              <div class="right">
                                <img src="{{trade.profile.image}}" />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-4">
                              <div>
                                <cdn-sell-button button-size="md" trade-id="{{trade.id}}" event-handler="dashboard.updateTrades()" />
                              </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="col-xs-12">
                                  <div class="right">
                                  <h3>{{layout.consts.siteCurrency}}{{trade.profile.current_price | number}}</h3>
                                  </div>
                                </div>
                                <div class="col-xs-12">
                                  <div class="right">
                                    <span ng-class="{'green': (trade.profile.current_price - trade.price_taken ) >= 0, 'red': (trade.profile.current_price - trade.price_taken ) < 0}"><h4>{{trade.change | percentageDifference:trade.price_taken:trade.profile.current_price  }}</h4></span>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="x_panel" ng-show="dashboard.popularHashtag">
                <div class="x_title">
                    <h2>Current Popular Profile Price History - {{dashboard.popularHashtag.tag}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <price-graph hashtag-id="{{dashboard.popularHashtag.id}}" />
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12">
          <div class="x_panel">
                <div class="x_title">
                    <h2>Popular Profiles</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" ng-class="{loadingsection: dashboard.control.hashtagsLoading}">
                  <div ng-repeat="profile in dashboard.popularHashtags" class="col-xs-12">
                      <div class="tile-stats container">
                        <div class="row name-container">
                          <div class="col-xs-8">
                            <div class="count">
                              <a href="/profile/{{profile.id}}">{{profile.name}}</a>
                            </div>
                          </div>
                          <div class="col-xs-4">
                            <div class="right">
                              <img src="{{profile.image}}" />
                            </div>
                          </div>
                        </div>
                        <div class="row">
                        <div class="col-xs-4">
                          <cdn-buy-button button-size="md" hashtag-id="{{profile.id}}" tag="{{profile.name}}" price="{{profile.current_price}}" event-handler="dashboard.updateTrades()" />
                        </div>
                          <div class="col-xs-8">
                              <div class="right">
                                <h3>{{layout.consts.siteCurrency}}{{profile.current_price | number}}</h3>
                              </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
            </div>


            <div class="x_panel">
                <div class="x_title">
                    <h2>Your Leagues</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" ng-class="{loadingsection: dashboard.control.leagueLoading}">
                  <table class="table">
                    <thead>
                    <tr>
                      <th colspan="2">Global</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="league in dashboard.globalLeagues">
                      <td scope="row">{{league.position}}</td><td><a href="/league/{{league.id}}">{{league.name | titlecase}}</a></td>
                    </tr>
                    <tr ng-show="dashboard.globalLeagues.length == 0 && !dashboard.control.leagueLoading">
                      <td class="no-record" colspan="2">No Global Leagues</td>
                    </tr>
                    <tr ng-show="dashboard.control.leagueLoading">
                      <td class="no-record" colspan="2"><img src="/cdn/ajax-loader.gif" /></td>
                    </tr>
                  </tbody>
                  </table>
                </div>

                <div class="x_content2" ng-class="{loadingsection: dashboard.control.leagueLoading}">
                  <table class="table">
                    <thead>
                    <tr>
                      <th colspan="2">Private</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="league in dashboard.privateLeagues">
                      <td scope="row">{{league.position}}</td><td><a href="/league/{{league.id}}">{{league.name | titlecase}}</a></td>
                    </tr>
                    <tr ng-show="dashboard.privateLeagues.length == 0 && !dashboard.control.leagueLoading">
                      <td class="no-record" colspan="2">No Private Leagues</td>
                    </tr>
                    <tr ng-show="dashboard.control.leagueLoading">
                      <td class="no-record" colspan="2"><img src="/cdn/ajax-loader.gif" /></td>
                    </tr>
                  </tbody>
                  </table>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
@stop
